<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Menampilkan halaman login
    public function index()
    {
        // Jika sudah login, arahkan sesuai role
        if (session()->get('logged_in')) {
            return $this->redirectByRole();
        }

        $data = [
            'judul' => 'Login SIPEDOK',
            'captcha' => $this->generateCaptcha()
        ];

        return view('auth/login', $data);
    }

    // Membuat CAPTCHA
    private function generateCaptcha()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $captcha = '';

        for ($i = 0; $i < 3; $i++) {
            $captcha .= $characters[random_int(0, strlen($characters) - 1)];
        }

        session()->set('captcha_answer', $captcha);

        return $captcha;
    }

    // Refresh CAPTCHA
    public function refreshCaptcha()
    {
        $captcha = $this->generateCaptcha();

        return $this->response->setJSON([
            'captcha' => $captcha
        ]);
    }

    // Proses login
    public function login()
    {
        $nip = trim($this->request->getPost('nip') ?? '');
        $password = $this->request->getPost('password') ?? '';
        $captchaInput = strtoupper(trim(
            $this->request->getPost('captcha') ?? ''
        ));

        $captchaAnswer = session()->get('captcha_answer');

        // Validasi input
        if ($nip === '' || $password === '' || $captchaInput === '') {
            session()->setFlashdata('error', 'Semua kolom wajib diisi.');
            return redirect()->to('/login')->withInput();
        }

        // Validasi CAPTCHA
        if (!$captchaAnswer || $captchaInput !== $captchaAnswer) {
            session()->remove('captcha_answer');
            session()->setFlashdata('error', 'Kode keamanan tidak sesuai.');
            return redirect()->to('/login');
        }

        session()->remove('captcha_answer');

        // Cari akun berdasarkan NIP
        $user = $this->userModel
            ->where('nip', $nip)
            ->first();

        // Periksa akun dan password
        if (!$user || !password_verify($password, $user['password'])) {
            session()->setFlashdata('error', 'NIP atau password salah.');
            return redirect()->to('/login')->withInput();
        }

        // Periksa status akun
        if ((int) $user['is_active'] !== 1) {
            session()->setFlashdata('error', 'Akun Anda sedang tidak aktif.');
            return redirect()->to('/login');
        }

        // Periksa role
        $allowedRoles = ['admin', 'pegawai', 'direktorat'];

        if (!in_array($user['role'], $allowedRoles, true)) {
            session()->setFlashdata('error', 'Hak akses akun tidak valid.');
            return redirect()->to('/login');
        }

        // Regenerasi session
        session()->regenerate(true);

        // Simpan data pengguna
        session()->set([
            'user_id'   => $user['id'],
            'nip'       => $user['nip'],
            'nama'      => $user['nama'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        session()->setFlashdata(
            'success',
            'Login berhasil. Selamat datang di SIPEDOK, ' . $user['nama'] . '.'
        );

        return $this->redirectByRole();
    }

    // Redirect berdasarkan role
    private function redirectByRole()
    {
        switch (session()->get('role')) {
            case 'admin':
                return redirect()->to('/admin/dashboard');

            case 'pegawai':
                return redirect()->to('/pegawai/dashboard');

            case 'direktorat':
                return redirect()->to('/direktorat/dashboard');

            default:
                session()->destroy();
                return redirect()->to('/login');
        }
    }

    // Logout
    public function logout()
    {
        session()->remove([
            'user_id',
            'nip',
            'nama',
            'role',
            'logged_in',
            'captcha_answer'
        ]);

        session()->regenerate(true);

        session()->setFlashdata(
            'success',
            'Anda berhasil keluar dari SIPEDOK.'
        );

        return redirect()->to('/login');
    }
}
