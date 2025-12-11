<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ChemistryController extends Controller
{
    // Konstanta untuk konfigurasi
    private const PASSING_GRADE = 60;
    private const QUIZ_TOTAL_QUESTIONS = 15;
    
    /**
     * Get teacher password hash from environment
     */
    private function getTeacherPasswordHash(): string
    {
        return env('TEACHER_PASSWORD_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
    }

    /**
     * Landing Page
     */
    public function landing()
    {
        $learningObjectives = [
            'Mengidentifikasi jenis-jenis gaya antar molekul',
            'Menjelaskan perbedaan antara gaya London, dipol-dipol, dan ikatan hidrogen',
            'Menganalisis faktor-faktor yang mempengaruhi kekuatan gaya antar molekul',
            'Menghubungkan gaya antar molekul dengan sifat fisika zat',
            'Memprediksi sifat fisika zat berdasarkan jenis gaya antar molekulnya'
        ];

        return view('landing', compact('learningObjectives'));
    }

    /**
     * Halaman Materi
     */
    public function materi()
    {
        $tujuanPembelajaran = [
            'Mengidentifikasi jenis-jenis gaya antar molekul',
            'Menjelaskan perbedaan antara gaya London, dipol-dipol, dan ikatan hidrogen',
            'Menganalisis faktor-faktor yang mempengaruhi kekuatan gaya antar molekul',
            'Menghubungkan gaya antar molekul dengan sifat fisika zat',
            'Memprediksi sifat fisika zat berdasarkan jenis gaya antar molekulnya'
        ];

        $materi = $this->getMateriContent();

        return view('materi', compact('materi', 'tujuanPembelajaran'));
    }

    /**
     * Halaman Simulasi
     */
    public function simulasi()
    {
        return view('simulasi');
    }

    /**
     * Halaman Kuis (Form Login)
     */
    public function kuis()
    {
        return view('kuis.login');
    }

    /**
     * Proses Login Kuis
     */
    public function kuisLogin(Request $request)
    {
        // Rate limiting untuk prevent spam
        $key = 'quiz-login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");
        }
        
        RateLimiter::hit($key, 60);

        // Enhanced validation
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'regex:/^[a-zA-Z\s]+$/',
            ],
            'kelas' => [
                'required',
                'string',
                'in:X IPA 1,X IPA 2,X IPA 3,X IPA 4,X IPA 5',
            ],
            'absen' => [
                'required',
                'integer',
                'min:1',
                'max:40'
            ]
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.min' => 'Nama minimal 3 karakter',
            'nama.max' => 'Nama maksimal 100 karakter',
            'nama.regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'kelas.required' => 'Kelas wajib dipilih',
            'kelas.in' => 'Kelas tidak valid',
            'absen.required' => 'Nomor absen wajib diisi',
            'absen.min' => 'Nomor absen minimal 1',
            'absen.max' => 'Nomor absen maksimal 40',
            'absen.integer' => 'Nomor absen harus berupa angka'
        ]);

        // Sanitize input untuk prevent XSS
        $sanitizedNama = strip_tags(trim($validated['nama']));
        $sanitizedNama = htmlspecialchars($sanitizedNama, ENT_QUOTES, 'UTF-8');

        Session::put([
            'siswa_nama' => $sanitizedNama,
            'siswa_kelas' => $validated['kelas'],
            'siswa_absen' => $validated['absen']
        ]);

        return redirect()->route('kuis.soal');
    }

    /**
     * Halaman Soal Kuis
     */
    public function kuisSoal()
    {
        if (!Session::has('siswa_nama')) {
            return redirect()->route('kuis.index')->with('error', 'Silakan login terlebih dahulu');
        }

        $soal = $this->getSoalKuis();

        return view('kuis.soal', compact('soal'));
    }

    /**
     * Submit Jawaban Kuis
     */
    public function kuisSubmit(Request $request)
    {
        if (!Session::has('siswa_nama')) {
            return redirect()->route('kuis.index')->with('error', 'Silakan login terlebih dahulu');
        }

        // Rate limiting untuk prevent spam submission
        $key = 'quiz-submit:' . Session::get('siswa_nama');
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Terlalu banyak submission. Tunggu sebentar.');
        }
        
        RateLimiter::hit($key, 300);

        $soal = $this->getSoalKuis();
        $jawaban = $request->input('jawaban', []);

        // Validate all answers are provided
        if (count($jawaban) !== self::QUIZ_TOTAL_QUESTIONS) {
            return back()->with('error', 'Harap jawab semua soal sebelum submit.');
        }

        // Validate answer format
        foreach ($jawaban as $index => $answer) {
            if (!in_array($answer, ['A', 'B', 'C', 'D', 'E'])) {
                return back()->with('error', 'Format jawaban tidak valid.');
            }
        }

        $benar = 0;
        $detailJawaban = [];

        foreach ($soal as $index => $item) {
            $jawabanSiswa = $jawaban[$index] ?? null;
            $isCorrect = $jawabanSiswa === $item['kunci'];

            if ($isCorrect) {
                $benar++;
            }

            $detailJawaban[] = [
                'nomor' => $index + 1,
                'pertanyaan' => $item['pertanyaan'],
                'jawaban_siswa' => $jawabanSiswa,
                'jawaban_benar' => $item['kunci'],
                'pembahasan' => $item['pembahasan'],
                'benar' => $isCorrect,
                'opsi_teks' => $item['pilihan_teks'][$jawabanSiswa] ?? 'Tidak menjawab',
                'kunci_teks' => $item['pilihan_teks'][$item['kunci']]
            ];
        }

        $nilai = round(($benar / self::QUIZ_TOTAL_QUESTIONS) * 100, 2);

        // Simpan hasil ke storage
        $this->saveQuizResult([
            'nama' => Session::get('siswa_nama'),
            'kelas' => Session::get('siswa_kelas'),
            'absen' => Session::get('siswa_absen'),
            'nilai' => $nilai,
            'benar' => $benar,
            'salah' => self::QUIZ_TOTAL_QUESTIONS - $benar,
            'detail' => $detailJawaban,
            'tanggal' => now()->format('Y-m-d H:i:s'),
            'ip_address' => request()->ip(),
        ]);

        // Clear session siswa
        Session::forget(['siswa_nama', 'siswa_kelas', 'siswa_absen']);
        RateLimiter::clear($key);

        return view('kuis.hasil', compact('nilai', 'benar', 'detailJawaban', 'soal'));
    }

    /**
     * Login Guru
     */
    public function guruLogin()
    {
        if (Session::has('guru_logged')) {
            return redirect()->route('guru.dashboard');
        }

        return view('guru.login');
    }

    /**
     * Autentikasi Guru
     */
    public function guruAuth(Request $request)
    {
        // Rate limiting
        $key = 'teacher-login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.");
        }

        $request->validate([
            'password' => 'required|string|min:6'
        ], [
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter'
        ]);

        // Use Hash::check for security
        $passwordHash = $this->getTeacherPasswordHash();
        
        if (Hash::check($request->password, $passwordHash)) {
            RateLimiter::clear($key);
            
            Session::put('guru_logged', true);
            Session::put('guru_login_time', now());
            Session::put('guru_session_id', Str::random(40));

            return redirect()->route('guru.dashboard')->with('success', 'Login berhasil!');
        }

        RateLimiter::hit($key, 60);
        return back()->with('error', 'Password salah! Silakan coba lagi.');
    }

    /**
     * Dashboard Guru
     */
    public function guruDashboard()
    {
        if (!Session::has('guru_logged')) {
            return redirect()->route('guru.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $data = $this->getQuizResults();
        $statistics = $this->calculateStatistics($data);

        return view('guru.dashboard', compact('data', 'statistics'));
    }

    /**
     * Export CSV
     */
    public function guruExport()
    {
        if (!Session::has('guru_logged')) {
            return redirect()->route('guru.login')->with('error', 'Silakan login terlebih dahulu');
        }

        $data = $this->getQuizResults();

        if (empty($data)) {
            return back()->with('error', 'Tidak ada data untuk diexport');
        }

        $filename = 'nilai_kuis_' . date('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'r+');

        // Header CSV dengan BOM untuk Excel compatibility
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($handle, ['No', 'Nama', 'Kelas', 'Absen', 'Nilai', 'Benar', 'Salah', 'Tanggal', 'IP Address']);

        foreach ($data as $index => $row) {
            fputcsv($handle, [
                $index + 1,
                $row['nama'],
                $row['kelas'],
                $row['absen'],
                number_format($row['nilai'], 2),
                $row['benar'],
                $row['salah'],
                $row['tanggal'],
                $row['ip_address'] ?? 'N/A'
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"")
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Logout Guru
     */
    public function guruLogout()
    {
        Session::forget(['guru_logged', 'guru_login_time', 'guru_session_id']);
        return redirect()->route('guru.login')->with('success', 'Logout berhasil');
    }

    // ========== PRIVATE HELPER METHODS ==========

    /**
     * Get materi content structure
     */
    private function getMateriContent(): array
    {
        return [
            [
                'judul' => '1. Gaya Antar Molekul',
                'isi' => 'Gaya antar molekul adalah gaya tarik-menarik yang terjadi ANTAR molekul (bukan di dalam molekul). Berbeda dengan ikatan intramolekul (ionik/kovalen) yang mengikat atom dalam molekul, gaya ini terjadi ANTAR molekul yang berbeda. Gaya ini lebih lemah dibandingkan ikatan kimia, tetapi sangat menentukan sifat fisika zat seperti titik didih dan viskositas.',
                'contoh' => 'Contoh: Air (H₂O) tetap cair di suhu kamar karena ada gaya antar molekul yang mengikat molekul-molekul air. Tanpa gaya ini, air akan langsung menjadi gas.',
                'icon' => '⚛️'
            ],
            [
                'judul' => '2. Jenis-Jenis Gaya Antar Molekul',
                'isi' => 'Ada 3 jenis utama gaya antar molekul, diurutkan dari yang terlemah hingga terkuat',
                'icon' => '🔬',
                'sub' => [
                    [
                        'nama' => 'Gaya London (Dispersi)',
                        'penjelasan' => 'Gaya terlemah, terjadi pada SEMUA molekul (polar maupun non-polar). Disebabkan oleh fluktuasi elektron yang menciptakan dipol sesaat. Semakin besar massa molekul, semakin kuat gaya London.',
                        'contoh' => 'Contoh: CH₄ (metana), CO₂, He, Ne',
                        'icon' => '🔴'
                    ],
                    [
                        'nama' => 'Dipol-Dipol',
                        'penjelasan' => 'Gaya sedang, hanya terjadi pada molekul POLAR (yang memiliki momen dipol permanen). Ujung positif satu molekul tertarik ke ujung negatif molekul lain.',
                        'contoh' => 'Contoh: HCl, SO₂, CH₃Cl',
                        'icon' => '🔵'
                    ],
                    [
                        'nama' => 'Ikatan Hidrogen',
                        'penjelasan' => 'Gaya terkuat (kasus khusus dipol-dipol), terjadi ketika atom H berikatan dengan atom F, O, atau N. Atom H yang bermuatan positif sangat tertarik ke atom elektronegatif (F/O/N) dari molekul lain.',
                        'contoh' => 'Contoh: H₂O, HF, NH₃, DNA, Protein',
                        'icon' => '🟣'
                    ]
                ]
            ],
            [
                'judul' => '3. Faktor-Faktor yang Mempengaruhi',
                'isi' => 'Kekuatan gaya antar molekul dipengaruhi oleh beberapa faktor utama',
                'icon' => '📊',
                'faktor' => [
                    [
                        'nama' => 'Massa Molekul Relatif (Mr)',
                        'penjelasan' => 'Semakin besar Mr, semakin banyak elektron, semakin kuat gaya London. Ini menjelaskan kenapa titik didih bertambah seiring bertambahnya ukuran molekul dalam satu golongan.',
                        'icon' => '📈'
                    ],
                    [
                        'nama' => 'Bentuk Molekul',
                        'penjelasan' => 'Molekul berbentuk panjang memiliki area kontak lebih besar dibanding molekul bulat dengan Mr sama, sehingga gaya London lebih kuat.',
                        'icon' => '🔬'
                    ],
                    [
                        'nama' => 'Kepolaran Molekul',
                        'penjelasan' => 'Molekul polar memiliki gaya dipol-dipol tambahan selain gaya London, sehingga total gayanya lebih kuat.',
                        'icon' => '⚛️'
                    ],
                    [
                        'nama' => 'Kemampuan Membentuk Ikatan Hidrogen',
                        'penjelasan' => 'Molekul dengan H-F, H-O, atau H-N memiliki gaya antar molekul JAUH lebih kuat karena ikatan hidrogen.',
                        'icon' => '💧'
                    ]
                ]
            ],
            [
                'judul' => '4. Hubungan dengan Sifat Fisika',
                'isi' => 'Kekuatan gaya antar molekul menentukan berbagai sifat fisika zat',
                'icon' => '🔗',
                'hubungan' => [
                    [
                        'sifat' => 'Titik Didih & Titik Leleh',
                        'penjelasan' => 'Semakin kuat gaya antar molekul, semakin tinggi titik didih dan titik leleh. Butuh energi lebih besar untuk memisahkan molekul-molekul yang saling tarik kuat.',
                        'contoh' => 'H₂O (100°C) > H₂S (-60°C) karena H₂O punya ikatan hidrogen',
                        'icon' => '🌡️'
                    ],
                    [
                        'sifat' => 'Viskositas (Kekentalan)',
                        'penjelasan' => 'Cairan dengan gaya antar molekul kuat lebih kental (viskositas tinggi) karena molekul sulit bergerak bebas.',
                        'contoh' => 'Gliserin (C₃H₈O₃) sangat kental karena banyak ikatan hidrogen',
                        'icon' => '💧'
                    ],
                    [
                        'sifat' => 'Tekanan Uap',
                        'penjelasan' => 'Semakin kuat gaya antar molekul, semakin rendah tekanan uap. Molekul sulit lepas ke fase gas.',
                        'contoh' => 'Air memiliki tekanan uap lebih rendah dari etanol pada suhu sama',
                        'icon' => '💨'
                    ]
                ]
            ]
        ];
    }

    /**
     * Get quiz questions (15 soal dengan pembahasan)
     */
    private function getSoalKuis(): array
    {
        return [
            [
                'nomor' => 1,
                'pertanyaan' => 'Gaya yang terjadi antara molekul polar dengan molekul polar disebut ...',
                'pilihan' => [
                    'A' => 'Gaya London',
                    'B' => 'Gaya induksi',
                    'C' => 'Gaya tarik-menarik dipol-dipol',
                    'D' => 'Gaya dispersi',
                    'E' => 'Ikatan hidrogen'
                ],
                'pilihan_teks' => [
                    'A' => 'Gaya London',
                    'B' => 'Gaya induksi', 
                    'C' => 'Gaya tarik-menarik dipol-dipol',
                    'D' => 'Gaya dispersi',
                    'E' => 'Ikatan hidrogen'
                ],
                'kunci' => 'C',
                'pembahasan' => 'Gaya dipol-dipol adalah gaya tarik-menarik elektrostatik yang terjadi antara dua molekul polar. Ujung positif parsial (δ+) dari satu molekul tertarik pada ujung negatif parsial (δ-) dari molekul lainnya.'
            ],
            [
                'nomor' => 2,
                'pertanyaan' => 'Pernyataan berikut tentang gaya London yang tidak benar adalah ....',
                'pilihan' => [
                    'A' => 'Ikatan-ikatan lebih kuat daripada ikatan dipol-dipol',
                    'B' => 'Ikatan dipol-dipol lebih kuat dari gaya London',
                    'C' => 'Makin besar ukuran atom, makin besar gaya londonnya',
                    'D' => 'Makin banyak rantai karbon, makin besar gaya londonnya',
                    'E' => 'Makin banyak rantai karbon, makin kecil gaya Londonnya'
                ],
                'pilihan_teks' => [
                    'A' => 'Ikatan-ikatan lebih kuat daripada ikatan dipol-dipol',
                    'B' => 'Ikatan dipol-dipol lebih kuat dari gaya London',
                    'C' => 'Makin besar ukuran atom, makin besar gaya londonnya',
                    'D' => 'Makin banyak rantai karbon, makin besar gaya londonnya',
                    'E' => 'Makin banyak rantai karbon, makin kecil gaya Londonnya'
                ],
                'kunci' => 'A',
                'pembahasan' => 'Gaya London (atau gaya dispersi) merupakan salah satu jenis gaya antarmolekul yang termasuk dalam gaya van der Waals. Gaya ini muncul akibat adanya dipol sesaat yang terbentuk karena pergeseran awan elektron dalam suatu molekul atau atom nonpolar. Besarnya gaya London bergantung pada jumlah elektron dan ukuran molekul atau atom semakin besar ukuran atom atau semakin panjang rantai karbon, maka semakin besar pula gaya Londonnya karena elektron lebih mudah terpolarisasi. Pernyataan "ikatan-ikatan lebih kuat daripada ikatan dipol-dipol" adalah tidak benar, karena justru gaya London merupakan gaya antarmolekul yang paling lemah, lebih lemah dibandingkan gaya dipol-dipol.'
            ],
            [
                'nomor' => 3,
                'pertanyaan' => 'Perhatikan harga titik didih beberapa senyawa berikut!<br>Senyawa: HI(-35°C), HBr(-67°C), HCl(-85°C), HF(+20°C), H₂S(-61°C), H₂O(+100°C)<br>Berdasarkan tabel di atas, senyawa yang mempunyai ikatan hidrogen adalah ....',
                'pilihan' => [
                    'A' => 'HI dan HBr',
                    'B' => 'HBr dan HF',
                    'C' => 'HF dan H₂O',
                    'D' => 'HCl dan HBr',
                    'E' => 'H₂S dan H₂O'
                ],
                'pilihan_teks' => [
                    'A' => 'HI dan HBr',
                    'B' => 'HBr dan HF',
                    'C' => 'HF dan H₂O',
                    'D' => 'HCl dan HBr',
                    'E' => 'H₂S dan H₂O'
                ],
                'kunci' => 'C',
                'pembahasan' => 'Ikatan hidrogen terbentuk ketika atom hidrogen terikat pada atom nonlogam sangat elektronegatif (F, O, atau N). Dari tabel, HF memiliki titik didih +20°C jauh lebih tinggi dari HCl (-85°C) padahal massa molekulnya lebih ringan. H₂O memiliki titik didih 100°C jauh lebih tinggi dari H₂S (-61°C) meskipun H₂S lebih berat. Ini menunjukkan HF dan H₂O memiliki ikatan hidrogen, sedangkan HI, HBr, HCl hanya memiliki gaya dipol-dipol karena halogenik lain tidak cukup elektronegatif.'
            ],
            [
                'nomor' => 4,
                'pertanyaan' => 'Manakah di bawah ini yang merupakan contoh senyawa yang dapat membentuk ikatan hidrogen?',
                'pilihan' => [
                    'A' => 'CH₄ (metana)',
                    'B' => 'CO₂ (karbon dioksida)',
                    'C' => 'NH₃ (amonia)',
                    'D' => 'CCl₄ (karbon tetraklorida)',
                    'E' => 'BF₃ (boron trifluorida)'
                ],
                'pilihan_teks' => [
                    'A' => 'CH₄ (metana)',
                    'B' => 'CO₂ (karbon dioksida)',
                    'C' => 'NH₃ (amonia)',
                    'D' => 'CCl₄ (karbon tetraklorida)',
                    'E' => 'BF₃ (boron trifluorida)'
                ],
                'kunci' => 'C',
                'pembahasan' => 'Syarat terbentuknya ikatan hidrogen adalah atom hidrogen harus terikat pada F, O, atau N yang sangat elektronegatif. NH₃ memenuhi syarat ini karena memiliki atom N yang sangat elektronegatif dan memiliki pasangan elektron bebas. CH₄ tidak memiliki H yang terikat pada atom elektronegatif, CO₂ tidak memiliki H, dan CCl₄ serta BF₃ juga tidak memiliki H, sehingga tidak dapat membentuk ikatan hidrogen.'
            ],
            [
                'nomor' => 5,
                'pertanyaan' => 'Perhatikan senyawa-senyawa berikut:<br>1. HF<br>2. CH₄<br>3. HCl<br>4. H₂O<br>Klasifikasikanlah senyawa yang memiliki gaya antarmolekul berupa ikatan hidrogen!',
                'pilihan' => [
                    'A' => '1 dan 2',
                    'B' => '1 dan 4',
                    'C' => '2 dan 3',
                    'D' => '3 dan 4',
                    'E' => '1, 2, dan 4'
                ],
                'pilihan_teks' => [
                    'A' => '1 dan 2',
                    'B' => '1 dan 4',
                    'C' => '2 dan 3',
                    'D' => '3 dan 4',
                    'E' => '1, 2, dan 4'
                ],
                'kunci' => 'B',
                'pembahasan' => 'HF (senyawa 1) memiliki ikatan hidrogen karena H terikat pada F yang sangat elektronegatif. H₂O (senyawa 4) juga memiliki ikatan hidrogen karena H terikat pada O yang sangat elektronegatif. Sebaliknya, CH₄ (senyawa 2) tidak memiliki atom elektronegatif yang diperlukan, dan HCl (senyawa 3) hanya memiliki gaya dipol-dipol karena Cl tidak cukup elektronegatif untuk membentuk ikatan hidrogen sejati.'
            ],
            [
                'nomor' => 6,
                'pertanyaan' => 'Dalam eksperimen laboratorium, Dika mengamati empat zat berbeda: garam dapur (NaCl) yang memerlukan suhu 801°C untuk meleleh dan menghantarkan listrik hanya dalam bentuk larutan; air (H₂O) yang memiliki titik didih tinggi (100°C) karena ikatan hidrogen namun tidak menghantarkan listrik dalam bentuk murni; gas metana (CH₄) yang memiliki titik didih sangat rendah (-164°C), tidak larut dalam air, dan tidak menghantarkan listrik. Ringkasan yang tepat dari bacaan di atas adalah...',
                'pilihan' => [
                    'A' => 'Semua zat memiliki sifat fisik yang sama karena terbuat dari unsur-unsur yang sama',
                    'B' => 'Zat ionik memiliki titik leleh tinggi dan menghantarkan listrik dalam larutan, zat kovalen nonpolar memiliki titik didih rendah',
                    'C' => 'Daya hantar listrik hanya dipengaruhi oleh kelarutan zat dalam air, sedangkan titik leleh dan titik didih tidak berhubungan dengan jenis ikatan kimia',
                    'D' => 'Ikatan hidrogen hanya terdapat pada zat padat, sementara zat gas tidak memiliki gaya antarmolekul apapun',
                    'E' => 'Zat yang tidak larut dalam air pasti memiliki titik leleh rendah, sedangkan zat yang larut dalam air pasti dapat menghantarkan listrik'
                ],
                'pilihan_teks' => [
                    'A' => 'Semua zat memiliki sifat fisik yang sama karena terbuat dari unsur-unsur yang sama',
                    'B' => 'Zat ionik memiliki titik leleh tinggi dan menghantarkan listrik dalam larutan, zat kovalen nonpolar memiliki titik didih rendah',
                    'C' => 'Daya hantar listrik hanya dipengaruhi oleh kelarutan zat dalam air, sedangkan titik leleh dan titik didih tidak berhubungan dengan jenis ikatan kimia',
                    'D' => 'Ikatan hidrogen hanya terdapat pada zat padat, sementara zat gas tidak memiliki gaya antarmolekul apapun',
                    'E' => 'Zat yang tidak larut dalam air pasti memiliki titik leleh rendah, sedangkan zat yang larut dalam air pasti dapat menghantarkan listrik'
                ],
                'kunci' => 'B',
                'pembahasan' => 'NaCl adalah zat ionik dengan titik leleh 801°C dan menghantarkan listrik dalam larutan karena gaya elektrostatik antar ion sangat kuat. H₂O adalah kovalen polar dengan titik didih tinggi (100°C) karena ikatan hidrogen. CH₄ adalah kovalen nonpolar dengan titik didih sangat rendah (-164°C) karena hanya memiliki gaya London yang lemah. Pernyataan B merangkum dengan tepat hubungan antara jenis ikatan dan sifat fisik zat.'
            ],
            [
                'nomor' => 7,
                'pertanyaan' => 'Jika diketahui bahwa molekul X bersifat polar dan dapat membentuk ikatan hidrogen, sedangkan molekul Y bersifat nonpolar, maka dapat disimpulkan bahwa …',
                'pilihan' => [
                    'A' => 'Molekul X memiliki titik didih lebih rendah dari molekul Y',
                    'B' => 'Molekul Y lebih mudah larut dalam air daripada molekul X',
                    'C' => 'Molekul X memiliki titik didih lebih tinggi dari molekul Y (jika massa molekul relatif sama)',
                    'D' => 'Kelarutan kedua molekul dalam air sama',
                    'E' => 'Molekul Y memiliki gaya antarmolekul yang lebih kuat'
                ],
                'pilihan_teks' => [
                    'A' => 'Molekul X memiliki titik didih lebih rendah dari molekul Y',
                    'B' => 'Molekul Y lebih mudah larut dalam air daripada molekul X',
                    'C' => 'Molekul X memiliki titik didih lebih tinggi dari molekul Y (jika massa molekul relatif sama)',
                    'D' => 'Kelarutan kedua molekul dalam air sama',
                    'E' => 'Molekul Y memiliki gaya antarmolekul yang lebih kuat'
                ],
                'kunci' => 'C',
                'pembahasan' => 'Gaya antarmolekul yang lebih kuat akan menghasilkan titik didih yang lebih tinggi. Molekul X bersifat polar dan membentuk ikatan hidrogen, sehingga memiliki gaya antarmolekul yang kuat. Molekul Y bersifat nonpolar, hanya memiliki gaya London yang lemah. Jika massa molekulnya sama, maka gaya antarmolekul X akan lebih kuat dari Y, sehingga titik didih X lebih tinggi dari Y.'
            ],
            [
                'nomor' => 8,
                'pertanyaan' => 'Bandingkan urutan kekuatan gaya antarmolekul dari yang paling lemah ke yang paling kuat untuk senyawa berikut: HF, CH₄, dan HCl!',
                'pilihan' => [
                    'A' => 'CH₄ < HCl < HF',
                    'B' => 'HF < HCl < CH₄',
                    'C' => 'HCl < CH₄ < HF',
                    'D' => 'CH₄ < HF < HCl',
                    'E' => 'HF < CH₄ < HCl'
                ],
                'pilihan_teks' => [
                    'A' => 'CH₄ < HCl < HF',
                    'B' => 'HF < HCl < CH₄',
                    'C' => 'HCl < CH₄ < HF',
                    'D' => 'CH₄ < HF < HCl',
                    'E' => 'HF < CH₄ < HCl'
                ],
                'kunci' => 'A',
                'pembahasan' => 'CH₄ adalah nonpolar sehingga hanya memiliki gaya London yang paling lemah. HCl adalah polar sehingga memiliki gaya dipol-dipol yang lebih kuat dari London. HF adalah polar dan membentuk ikatan hidrogen, sehingga memiliki gaya antarmolekul paling kuat. Hal ini dapat dibuktikan dari titik didih masing-masing: CH₄ (-161°C), HCl (-85°C), dan HF (+20°C). Semakin tinggi titik didih, semakin kuat gaya antarmolekul.'
            ],
            [
                'nomor' => 9,
                'pertanyaan' => 'Konfigurasi electron dari unsur D dan E:<br>D = [He] 2s² 2p⁵<br>E = [Ne] 3s² 3p³<br>Rumus kimia dan bentuk molekul yang terbentuk jika kedua unsur tersebut berikatan adalah …',
                'pilihan' => [
                    'A' => 'ED, linear',
                    'B' => 'ED₃, bipiramida trigonal',
                    'C' => 'E₂D, linear',
                    'D' => 'ED₂, planar ventu V',
                    'E' => 'E₄D, tetrahedron'
                ],
                'pilihan_teks' => [
                    'A' => 'ED, linear',
                    'B' => 'ED₃, bipiramida trigonal',
                    'C' => 'E₂D, linear',
                    'D' => 'ED₂, planar ventu V',
                    'E' => 'E₄D, tetrahedron'
                ],
                'kunci' => 'B',
                'pembahasan' => 'Unsur D [He] 2s² 2p⁵ adalah Fluorin (F) dengan 7 elektron valensi, dan unsur E [Ne] 3s² 3p³ adalah Phosphorus (P) dengan 5 elektron valensi. Ketika keduanya berikatan, P dapat mengikat 5 atom F membentuk PF₅ (ED₅). Geometri PF₅ adalah bipiramida trigonal dengan 5 pasangan elektron ikatan di sekitar atom pusat P dan tidak ada pasangan elektron bebas.'
            ],
            [
                'nomor' => 10,
                'pertanyaan' => 'Seorang ahli kimia ingin memilih pelarut yang tepat untuk melarutkan vitamin C (asam askorbat) yang memiliki banyak gugus -OH. Berdasarkan prinsip "like dissolves like" dan konsep gaya antarmolekul, pelarut manakah yang paling cocok?',
                'pilihan' => [
                    'A' => 'Heksana (C₆H₁₄)',
                    'B' => 'Benzena (C₆H₆)',
                    'C' => 'Air (H₂O)',
                    'D' => 'Karbon tetraklorida (CCl₄)',
                    'E' => 'Minyak'
                ],
                'pilihan_teks' => [
                    'A' => 'Heksana (C₆H₁₄)',
                    'B' => 'Benzena (C₆H₆)',
                    'C' => 'Air (H₂O)',
                    'D' => 'Karbon tetraklorida (CCl₄)',
                    'E' => 'Minyak'
                ],
                'kunci' => 'C',
                'pembahasan' => 'Vitamin C memiliki banyak gugus -OH sehingga bersifat sangat polar. Berdasarkan prinsip "like dissolves like", zat akan larut baik dalam pelarut yang memiliki polaritas sama. Air adalah pelarut universal yang polar dan dapat membentuk ikatan hidrogen dengan gugus -OH pada vitamin C, sehingga paling cocok untuk melarutkan vitamin C. Sebaliknya, heksana, benzena, CCl₄, dan minyak semuanya nonpolar sehingga tidak dapat melarutkan vitamin C dengan baik.'
            ],
            [
                'nomor' => 11,
                'pertanyaan' => 'Mengapa air (H₂O) memiliki titik didih lebih tinggi dari etanol (CH₃CH₂OH) yang memiliki ukuran molekul lebih besar?',
                'pilihan' => [
                    'A' => 'Karena air memiliki massa molekul yang lebih kecil',
                    'B' => 'Karena ikatan hidrogen pada air lebih kuat dan lebih banyak',
                    'C' => 'Karena etanol tidak memiliki ikatan hidrogen',
                    'D' => 'Karena air memiliki gaya London yang lebih kuat',
                    'E' => 'Karena etanol adalah senyawa nonpolar'
                ],
                'pilihan_teks' => [
                    'A' => 'Karena air memiliki massa molekul yang lebih kecil',
                    'B' => 'Karena ikatan hidrogen pada air lebih kuat dan lebih banyak',
                    'C' => 'Karena etanol tidak memiliki ikatan hidrogen',
                    'D' => 'Karena air memiliki gaya London yang lebih kuat',
                    'E' => 'Karena etanol adalah senyawa nonpolar'
                ],
                'kunci' => 'B',
                'pembahasan' => 'Meskipun etanol (CH₃CH₂OH) memiliki ukuran molekul lebih besar, air memiliki titik didih lebih tinggi karena ikatan hidrogen pada air lebih terjalin rapat. Setiap molekul air dapat membentuk hingga 4 ikatan hidrogen (2 sebagai donor melalui H, 2 sebagai akseptor melalui pasangan elektron O), sedangkan etanol hanya memiliki 1 gugus -OH. Jumlah dan kekuatan ikatan hidrogen pada air jauh lebih besar dibanding gaya London pada rantai karbon etanol.'
            ],
            [
                'nomor' => 12,
                'pertanyaan' => 'Manakah dari berikut ini yang memiliki gaya antarmolekul paling kuat?',
                'pilihan' => [
                    'A' => 'CH₄ (metana)',
                    'B' => 'HCl (asam klorida)',
                    'C' => 'H₂O (air)',
                    'D' => 'CO₂ (karbon dioksida)',
                    'E' => 'Cl₂ (klorin)'
                ],
                'pilihan_teks' => [
                    'A' => 'CH₄ (metana)',
                    'B' => 'HCl (asam klorida)',
                    'C' => 'H₂O (air)',
                    'D' => 'CO₂ (karbon dioksida)',
                    'E' => 'Cl₂ (klorin)'
                ],
                'kunci' => 'C',
                'pembahasan' => 'H₂O memiliki ikatan hidrogen yang merupakan gaya antarmolekul terkuat di antara pilihan yang ada. CH₄ dan CO₂ hanya memiliki gaya London, HCl memiliki gaya dipol-dipol, sedangkan Cl₂ hanya memiliki gaya London yang lemah karena nonpolar.'
            ],
            [
                'nomor' => 13,
                'pertanyaan' => 'Faktor utama yang mempengaruhi kekuatan gaya London adalah...',
                'pilihan' => [
                    'A' => 'Kepolaran molekul',
                    'B' => 'Ukuran dan massa molekul',
                    'C' => 'Jenis atom yang berikatan',
                    'D' => 'Bentuk molekul saja',
                    'E' => 'Warna senyawa'
                ],
                'pilihan_teks' => [
                    'A' => 'Kepolaran molekul',
                    'B' => 'Ukuran dan massa molekul',
                    'C' => 'Jenis atom yang berikatan',
                    'D' => 'Bentuk molekul saja',
                    'E' => 'Warna senyawa'
                ],
                'kunci' => 'B',
                'pembahasan' => 'Gaya London bergantung pada ukuran dan massa molekul. Semakin besar ukuran molekul (semakin banyak elektron), semakin mudah elektron terdistribusi tidak merata membentuk dipol sesaat, sehingga gaya London semakin kuat.'
            ],
            [
                'nomor' => 14,
                'pertanyaan' => 'Senyawa manakah yang paling mungkin larut dalam air?',
                'pilihan' => [
                    'A' => 'C₆H₁₄ (heksana)',
                    'B' => 'CCl₄ (karbon tetraklorida)',
                    'C' => 'CH₃OH (metanol)',
                    'D' => 'C₆H₆ (benzena)',
                    'E' => 'C₈H₁₈ (oktana)'
                ],
                'pilihan_teks' => [
                    'A' => 'C₆H₁₄ (heksana)',
                    'B' => 'CCl₄ (karbon tetraklorida)',
                    'C' => 'CH₃OH (metanol)',
                    'D' => 'C₆H₆ (benzena)',
                    'E' => 'C₈H₁₈ (oktana)'
                ],
                'kunci' => 'C',
                'pembahasan' => 'Metanol (CH₃OH) dapat larut dalam air karena memiliki gugus -OH yang dapat membentuk ikatan hidrogen dengan air. Senyawa-senyawa lainnya (heksana, CCl₄, benzena, oktana) adalah nonpolar sehingga tidak larut dalam air.'
            ],
            [
                'nomor' => 15,
                'pertanyaan' => 'Manakah pernyataan yang benar tentang ikatan hidrogen?',
                'pilihan' => [
                    'A' => 'Hanya terjadi antara molekul yang sama',
                    'B' => 'Lebih kuat dari ikatan kovalen',
                    'C' => 'Terjadi ketika H terikat pada atom F, O, atau N',
                    'D' => 'Tidak mempengaruhi titik didih',
                    'E' => 'Hanya terjadi pada senyawa organik'
                ],
                'pilihan_teks' => [
                    'A' => 'Hanya terjadi antara molekul yang sama',
                    'B' => 'Lebih kuat dari ikatan kovalen',
                    'C' => 'Terjadi ketika H terikat pada atom F, O, atau N',
                    'D' => 'Tidak mempengaruhi titik didih',
                    'E' => 'Hanya terjadi pada senyawa organik'
                ],
                'kunci' => 'C',
                'pembahasan' => 'Ikatan hidrogen terjadi ketika atom hidrogen terikat pada atom yang sangat elektronegatif seperti Fluor (F), Oksigen (O), atau Nitrogen (N). Ikatan hidrogen adalah gaya antarmolekul, bukan ikatan intramolekul seperti ikatan kovalen, dan mempengaruhi sifat fisika seperti titik didih.'
            ]
        ];
    }

    /**
     * Save quiz result to storage
     */
    private function saveQuizResult(array $data): void
    {
        try {
            $filename = 'hasil_kuis.json';
            $existingData = [];

            if (Storage::exists($filename)) {
                $content = Storage::get($filename);
                $existingData = json_decode($content, true) ?? [];
            }

            $existingData[] = $data;
            
            $jsonContent = json_encode($existingData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            
            if ($jsonContent === false) {
                \Log::error('Failed to encode quiz results to JSON');
                return;
            }

            Storage::put($filename, $jsonContent);
            
        } catch (\Exception $e) {
            \Log::error('Failed to save quiz result: ' . $e->getMessage());
        }
    }

    /**
     * Get quiz results from storage
     */
    private function getQuizResults(): array
    {
        try {
            $filename = 'hasil_kuis.json';

            if (!Storage::exists($filename)) {
                return [];
            }

            $content = Storage::get($filename);
            return json_decode($content, true) ?? [];
            
        } catch (\Exception $e) {
            \Log::error('Failed to get quiz results: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Calculate statistics from quiz data
     */
    private function calculateStatistics(array $data): array
    {
        if (empty($data)) {
            return [
                'total_siswa' => 0,
                'rata_rata' => 0,
                'lulus' => 0,
                'tidak_lulus' => 0,
                'nilai_tertinggi' => 0,
                'nilai_terendah' => 0,
                'persentase_lulus' => 0,
            ];
        }

        $nilaiArray = array_column($data, 'nilai');
        $lulus = count(array_filter($nilaiArray, fn($n) => $n >= self::PASSING_GRADE));
        $totalSiswa = count($data);

        return [
            'total_siswa' => $totalSiswa,
            'rata_rata' => round(array_sum($nilaiArray) / $totalSiswa, 2),
            'lulus' => $lulus,
            'tidak_lulus' => $totalSiswa - $lulus,
            'nilai_tertinggi' => max($nilaiArray),
            'nilai_terendah' => min($nilaiArray),
            'persentase_lulus' => round(($lulus / $totalSiswa) * 100, 2),
        ];
    }
}