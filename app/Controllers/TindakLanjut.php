<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TindakLanjut extends Controller
{
    private const MAX_PDF_SIZE = 20 * 1024 * 1024;
    private const MAX_REDIRECTS = 8;

    public function index()
    {
        $db = \Config\Database::connect();

        $riwayat = $db->table('tindak_lanjut')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('sipedok/tindak_lanjut', [
            'riwayat' => $riwayat
        ]);
    }

    public function verifikasi()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Permintaan tidak valid.',
                'csrfHash' => csrf_hash()
            ]);
        }

        $nama  = trim((string) $this->request->getPost('nama'));
        $jenis = trim((string) $this->request->getPost('jenis'));
        $tahun = (int) $this->request->getPost('tahun');
        $link  = trim((string) $this->request->getPost('link_dokumen'));

        if ($nama === '' || $jenis === '' || $tahun < 2023 || $tahun > 2029 || $link === '') {
            return $this->jsonError(422, 'Lengkapi seluruh informasi dokumen.');
        }

        if (!$this->isAllowedOneDriveUrl($link)) {
            return $this->jsonError(
                422,
                'Link harus berupa link HTTPS OneDrive atau SharePoint yang sah.'
            );
        }

        $uploadPath = WRITEPATH . 'uploads/dokumen/tmp/';

        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0750, true) && !is_dir($uploadPath)) {
            return $this->jsonError(500, 'Folder sementara dokumen gagal dibuat.');
        }

        // File hanya disimpan sementara di server untuk diperiksa pyHanko.
        $pdfPath = $uploadPath . bin2hex(random_bytes(16)) . '.pdf';

        try {
            $download = $this->downloadOneDrivePdf($link, $pdfPath);

            if (!$download['success']) {
                return $this->jsonError(
                    $download['http_code'] ?? 422,
                    $download['message']
                );
            }

            $pythonScript = ROOTPATH . 'python' . DIRECTORY_SEPARATOR . 'validasi_pdf.py';

            // Sesuaikan dengan lokasi Python 3.11 yang sudah terpasang pyHanko.
            $pythonExe = 'C:\Users\Abah46_PC\AppData\Local\Programs\Python\Python311\python.exe';

            if (!is_file($pythonScript)) {
                return $this->jsonError(500, 'File program validasi_pdf.py tidak ditemukan.', [
                    'lokasi_dicari' => $pythonScript
                ]);
            }

            if (!is_file($pythonExe)) {
                return $this->jsonError(500, 'Python 3.11 tidak ditemukan.', [
                    'lokasi_dicari' => $pythonExe
                ]);
            }

            $command = escapeshellarg($pythonExe) . ' ' .
                escapeshellarg($pythonScript) . ' ' .
                escapeshellarg($pdfPath) . ' 2>&1';

            $output = [];
            $exitCode = 0;
            exec($command, $output, $exitCode);

            $hasilOutput = implode("\n", $output);
            $result = null;
            $lines = preg_split('/\r\n|\r|\n/', trim($hasilOutput));

            foreach (array_reverse($lines) as $line) {
                $decoded = json_decode($line, true);

                if (is_array($decoded) && isset($decoded['status'])) {
                    $result = $decoded;
                    break;
                }
            }

            if (!is_array($result)) {
                return $this->jsonError(500, 'Hasil validasi PDF tidak dapat dibaca.', [
                    'detail' => $hasilOutput,
                    'exit_code' => $exitCode,
                    'python' => $pythonExe,
                    'script' => $pythonScript
                ]);
            }

            $status = $result['status'] ?? 'review';
            $allowedStatus = ['valid', 'unsigned', 'invalid', 'review'];

            if (!in_array($status, $allowedStatus, true)) {
                $status = 'review';
            }

            $pesan = is_string($result['message'] ?? null)
                ? $result['message']
                : 'Hasil validasi tidak tersedia.';

            $sertifikat = $result['certificate'] ?? '';
            if (!is_string($sertifikat)) {
                $sertifikat = json_encode($sertifikat, JSON_UNESCAPED_UNICODE);
            }

            $db = \Config\Database::connect();

            $berhasil = $db->table('tindak_lanjut')->insert([
                'nama_pegawai' => $nama,
                'jenis_dokumen' => $jenis,
                'tahun' => $tahun,
                // Dipertahankan agar tetap kompatibel dengan kolom lama yang mungkin NOT NULL.
                'nama_file' => 'Dokumen OneDrive.pdf',
                'link_dokumen' => $link,
                'status_validasi' => $status,
                'pesan_validasi' => $pesan,
                'informasi_sertifikat' => $sertifikat
            ]);

            if (!$berhasil) {
                return $this->jsonError(500, 'Hasil validasi gagal disimpan ke database.');
            }

            return $this->response->setJSON([
                'success' => true,
                'status' => $status,
                'message' => $pesan,
                'certificate' => $sertifikat,
                'csrfHash' => csrf_hash()
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Verifikasi OneDrive gagal: ' . $e->getMessage());

            return $this->jsonError(500, 'Terjadi kesalahan saat mengambil atau memeriksa dokumen.');
        } finally {
            if (is_file($pdfPath)) {
                @unlink($pdfPath);
            }
        }
    }

    /**
     * Mengambil PDF dari link berbagi OneDrive dengan mengikuti redirect secara manual.
     * Hanya domain Microsoft/OneDrive yang diizinkan untuk mengurangi risiko SSRF.
     */
    private function downloadOneDrivePdf(string $url, string $destination): array
    {
        if (!function_exists('curl_init')) {
            return [
                'success' => false,
                'http_code' => 500,
                'message' => 'Ekstensi PHP cURL belum aktif.'
            ];
        }

        // Minta OneDrive mengirim file, bukan halaman preview.
        $url = $this->addDownloadParameter($url);

        for ($attempt = 0; $attempt <= self::MAX_REDIRECTS; $attempt++) {
            if (!$this->isAllowedOneDriveUrl($url)) {
                return [
                    'success' => false,
                    'http_code' => 422,
                    'message' => 'Tujuan link OneDrive tidak diizinkan.'
                ];
            }

            $location = null;
            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_CONNECTTIMEOUT => 15,
                CURLOPT_TIMEOUT => 90,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_PROTOCOLS => CURLPROTO_HTTPS,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/pdf,application/octet-stream,*/*'
                ],
                CURLOPT_USERAGENT => 'SIPEDOK-PDF-Checker/1.0',
                CURLOPT_HEADERFUNCTION => function ($curl, $header) use (&$location) {
                    if (stripos($header, 'Location:') === 0) {
                        $location = trim(substr($header, 9));
                    }
                    return strlen($header);
                }
            ]);

            $body = curl_exec($ch);
            $curlError = curl_error($ch);
            $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($body === false) {
                return [
                    'success' => false,
                    'http_code' => 502,
                    'message' => 'Gagal mengambil dokumen dari OneDrive: ' . $curlError
                ];
            }

            if (in_array($httpCode, [301, 302, 303, 307, 308], true) && $location) {
                if ($attempt === self::MAX_REDIRECTS) {
                    return [
                        'success' => false,
                        'http_code' => 502,
                        'message' => 'Link OneDrive mengarahkan terlalu banyak halaman.'
                    ];
                }

                $url = $this->resolveRedirectUrl($url, $location);
                continue;
            }

            if ($httpCode !== 200) {
                return [
                    'success' => false,
                    'http_code' => 422,
                    'message' => 'Dokumen tidak dapat diakses. Pastikan pengaturan link OneDrive adalah Anyone with the link dan link masih aktif. HTTP: ' . $httpCode
                ];
            }

            if (strlen($body) > self::MAX_PDF_SIZE) {
                return [
                    'success' => false,
                    'http_code' => 422,
                    'message' => 'Ukuran PDF melebihi batas maksimal 20 MB.'
                ];
            }

            if (strncmp($body, '%PDF-', 5) !== 0) {
                return [
                    'success' => false,
                    'http_code' => 422,
                    'message' => 'Link tidak menghasilkan file PDF. Pastikan link mengarah ke dokumen PDF, bukan folder atau halaman preview.'
                ];
            }

            if (file_put_contents($destination, $body) === false) {
                return [
                    'success' => false,
                    'http_code' => 500,
                    'message' => 'PDF gagal disimpan sementara di server.'
                ];
            }

            return ['success' => true, 'http_code' => 200, 'message' => 'PDF berhasil diambil.'];
        }

        return [
            'success' => false,
            'http_code' => 502,
            'message' => 'Dokumen OneDrive gagal diakses.'
        ];
    }

    private function addDownloadParameter(string $url): string
    {
        $parts = parse_url($url);
        if (!$parts) {
            return $url;
        }

        parse_str($parts['query'] ?? '', $query);

        if (isset($query['download'])) {
            return $url;
        }

        $separator = isset($parts['query']) && $parts['query'] !== '' ? '&' : '?';
        $fragmentPosition = strpos($url, '#');

        if ($fragmentPosition !== false) {
            $beforeFragment = substr($url, 0, $fragmentPosition);
            $fragment = substr($url, $fragmentPosition);
            return $beforeFragment . $separator . 'download=1' . $fragment;
        }

        return $url . $separator . 'download=1';
    }

    private function isAllowedOneDriveUrl(string $url): bool
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $parts = parse_url($url);

        if (
            !$parts ||
            strtolower($parts['scheme'] ?? '') !== 'https' ||
            empty($parts['host']) ||
            isset($parts['user']) ||
            isset($parts['pass'])
        ) {
            return false;
        }

        $host = strtolower(rtrim($parts['host'], '.'));

        $allowedExact = [
            '1drv.ms',
            'onedrive.live.com'
        ];

        if (in_array($host, $allowedExact, true)) {
            return true;
        }

        $allowedSuffixes = [
            '.1drv.ms',
            '.1drv.com',
            '.onedrive.com',
            '.live.com',
            '.sharepoint.com',
            '.sharepointonline.com',
            '.office.com'
        ];

        foreach ($allowedSuffixes as $suffix) {
            if (str_ends_with($host, $suffix)) {
                return true;
            }
        }

        return false;
    }

    private function resolveRedirectUrl(string $baseUrl, string $location): string
    {
        if (preg_match('#^https://#i', $location)) {
            return $location;
        }

        if (str_starts_with($location, '//')) {
            return 'https:' . $location;
        }

        $base = parse_url($baseUrl);
        $origin = 'https://' . ($base['host'] ?? '');

        if (isset($base['port'])) {
            $origin .= ':' . $base['port'];
        }

        if (str_starts_with($location, '/')) {
            return $origin . $location;
        }

        if (str_starts_with($location, '?')) {
            return $origin . ($base['path'] ?? '/') . $location;
        }

        $basePath = $base['path'] ?? '/';
        $directory = substr($basePath, 0, strrpos($basePath, '/') + 1);

        return $origin . $directory . $location;
    }

    private function jsonError(int $statusCode, string $message, array $extra = [])
    {
        return $this->response->setStatusCode($statusCode)->setJSON(array_merge([
            'success' => false,
            'message' => $message,
            'csrfHash' => csrf_hash()
        ], $extra));
    }

    public function riwayat()
    {
        $db = \Config\Database::connect();

        $data = $db->table('tindak_lanjut')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data' => $data,
            'csrfHash' => csrf_hash()
        ]);
    }
}
