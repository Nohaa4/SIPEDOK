
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==========================================
// HALAMAN UTAMA DAN LOGIN
// ==========================================

$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');

// Refresh CAPTCHA
$routes->get('login/captcha', 'Auth::refreshCaptcha');

// Logout
$routes->get('logout', 'Auth::logout');


// ==========================================
// DASHBOARD BERDASARKAN ROLE
// ==========================================

// Admin
$routes->get('admin/dashboard', 'Sipedok::index');

// Pegawai
$routes->get('pegawai/dashboard', 'Sipedok::dashboardPegawai');

// Direktorat
$routes->get('direktorat/dashboard', 'Sipedok::dashboardDirektorat');


// ==========================================
// MENU ADMIN
// ==========================================

// Data Pegawai
$routes->get('data-pegawai', 'Sipedok::dataPegawai');

// Monitoring Dokumen
$routes->get('monitoring-dokumen', 'Sipedok::monitoringDokumen');
$routes->get('monitoring-dokumen/(:segment)', 'Sipedok::detailPegawai/$1');

// Tindak Lanjut
$routes->get('tindak-lanjut', 'TindakLanjut::index');
$routes->post('tindak-lanjut/verifikasi', 'TindakLanjut::verifikasi');
$routes->get('tindak-lanjut/riwayat', 'TindakLanjut::riwayat');

// Laporan
$routes->get('laporan', 'Sipedok::laporan');


// ==========================================
// EMAIL
// ==========================================

$routes->get('test-email-sipedok', 'EmailSipedok::test');


// ==========================================
// MENU PEGAWAI
// ==========================================

// Pelaporan Dokumen
$routes->get('pegawai/pelaporan', 'Pelaporan::index');
$routes->post('pegawai/pelaporan/simpan', 'Pelaporan::simpan');

// Riwayat Pelaporan
$routes->get('pegawai/riwayat', 'Pelaporan::riwayat');

// Profil Pegawai
$routes->get('pegawai/profil', 'Pelaporan::profil');
