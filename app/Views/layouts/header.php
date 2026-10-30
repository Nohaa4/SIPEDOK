<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($judul) ?> | Sistem Informasi Pelaporan Dokumen Pegawai</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet"
          href="<?= base_url('assets/sipedok/css/style.css') ?>">
</head>
<body>

<div class="app-layout">

    <aside class="sidebar">

        <a href="<?= site_url('dashboard') ?>" class="brand">
            <span class="brand-logo" aria-hidden="true">
                <i></i>
                <i></i>
                <i></i>
                <i></i>
            </span>

            <span class="brand-text">
                <strong>SIPEDOK</strong>
                <small>Sistem Informasi</small>
                <small>Pelaporan Dokumen Pegawai</small>
            </span>
        </a>

        <div class="menu-label">MENU UTAMA</div>

        <nav class="sidebar-menu">
            <a href="<?= site_url('dashboard') ?>"
               class="menu-item active">
                <i class="bi bi-house"></i>
                <span>Dashboard</span>
            </a>

            <a href="<?= site_url('data-pegawai') ?>" class="menu-item">
                <i class="bi bi-person"></i>
                <span>Data Pegawai</span>
            </a>

            <a href="<?= site_url('monitoring-dokumen') ?>"class="menu-item <?= url_is('monitoring-dokumen') ? 'active' : '' ?>">
                <i class="bi bi-card-list"></i>
                <span>Monitoring Dokumen</span>
            </a>

            <a href="<?= site_url('tindak-lanjut') ?>"class="menu-item <?= url_is('tindak-lanjut') ? 'active' : '' ?>">
                <i class="bi bi-list-task"></i>
                <span>Tindak Lanjut</span>
                <span class="menu-badge">0</span>
            </a>

            <a href="#laporan" class="menu-item">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Laporan</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="profile-icon">
                <i class="bi bi-person"></i>
            </div>

            <div class="profile-info">
                <strong>Pengelola Dokumen</strong>
                <small>SIPEDOK</small>
            </div>

            <i class="bi bi-three-dots"></i>
        </div>

    </aside>

    <main class="main-content">
