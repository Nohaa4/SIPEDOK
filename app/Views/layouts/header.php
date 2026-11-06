
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($judul ?? 'Dashboard SIPEDOK') ?></title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/sipedok/css/dashboard.css') ?>?v=7">
</head>

<body>

<?php
$role = strtolower(session()->get('role') ?? '');
$nama = session()->get('nama') ?? 'Pengguna SIPEDOK';
$currentUri = uri_string();

/*
|--------------------------------------------------------------------------
| Dashboard berdasarkan role
|--------------------------------------------------------------------------
*/
$dashboardUrl = match ($role) {
    'admin'      => 'admin/dashboard',
    'direktorat' => 'direktorat/dashboard',
    'pegawai'    => 'pegawai/dashboard',
    default      => 'login',
};

/*
|--------------------------------------------------------------------------
| Menu berdasarkan role
|--------------------------------------------------------------------------
*/
$menuAdmin = [
    [
        'label' => 'Dashboard',
        'icon'  => 'bi-house-door-fill',
        'url'   => 'admin/dashboard',
        'active' => ['admin/dashboard', 'dashboard'],
    ],
    [
        'label' => 'Data Pegawai',
        'icon'  => 'bi-people-fill',
        'url'   => 'data-pegawai',
        'active' => ['data-pegawai'],
    ],
    [
        'label' => 'Monitoring Dokumen',
        'icon'  => 'bi-file-earmark-text',
        'url'   => 'monitoring-dokumen',
        'active' => ['monitoring-dokumen'],
    ],
    [
        'label' => 'Tindak Lanjut',
        'icon'  => 'bi-list-check',
        'url'   => 'tindak-lanjut',
        'active' => ['tindak-lanjut'],
    ],
    [
        'label' => 'Laporan',
        'icon'  => 'bi-bar-chart-fill',
        'url'   => 'laporan',
        'active' => ['laporan'],
    ],
];

$menuDirektorat = [
    [
        'label' => 'Dashboard',
        'icon'  => 'bi-house-door-fill',
        'url'   => 'direktorat/dashboard',
        'active' => ['direktorat/dashboard'],
    ],
    [
        'label' => 'Data Pegawai',
        'icon'  => 'bi-people-fill',
        'url'   => 'direktorat/data-pegawai',
        'active' => ['direktorat/data-pegawai'],
    ],
    [
        'label' => 'Monitoring Dokumen',
        'icon'  => 'bi-file-earmark-text',
        'url'   => 'direktorat/monitoring-dokumen',
        'active' => ['direktorat/monitoring-dokumen'],
    ],
    [
        'label' => 'Tindak Lanjut',
        'icon'  => 'bi-list-check',
        'url'   => 'direktorat/tindak-lanjut',
        'active' => ['direktorat/tindak-lanjut'],
    ],
    [
        'label' => 'Laporan',
        'icon'  => 'bi-bar-chart-fill',
        'url'   => 'direktorat/laporan',
        'active' => ['direktorat/laporan'],
    ],
];

$menuPegawai = [
    [
        'label' => 'Dashboard',
        'icon'  => 'bi-house-door-fill',
        'url'   => 'pegawai/dashboard',
        'active' => ['pegawai/dashboard'],
    ],
    [
        'label' => 'Pelaporan Dokumen',
        'icon'  => 'bi-file-earmark-arrow-up',
        'url'   => 'pegawai/pelaporan',
        'active' => ['pegawai/pelaporan'],
    ],
    [
        'label' => 'Profil Saya',
        'icon'  => 'bi-person',
        'url'   => 'pegawai/profil',
        'active' => ['pegawai/profil'],
    ],
];

$menu = match ($role) {
    'admin'      => $menuAdmin,
    'direktorat' => $menuDirektorat,
    'pegawai'    => $menuPegawai,
    default      => [],
};
?>

<div class="sip-layout">

    <!-- SIDEBAR -->
    <aside class="sip-sidebar">

        <!-- LOGO DAN IDENTITAS -->
        <div class="sip-brand">

            <div class="sip-brand-logo">
                <img
                    src="<?= base_url('assets/sipedok/img/logo-sipedok.png') ?>"
                    alt="Logo SIPEDOK"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                >

                <span class="sip-logo-fallback">
                    <i class="bi bi-file-earmark-text"></i>
                </span>
            </div>

            <div class="sip-brand-text">
                <h2>SIPEDOK</h2>
                <p>
                    Sistem Informasi<br>
                    Pelaporan Dokumen Pegawai
                </p>
            </div>

        </div>

        <div class="sip-divider"></div>

        <!-- MENU -->
        <div class="sip-menu-title">MENU UTAMA</div>

        <nav class="sip-nav">

            <?php foreach ($menu as $item): ?>

                <?php
                $isActive = in_array($currentUri, $item['active'], true);
                ?>

                <a href="<?= site_url($item['url']) ?>"
                   class="sip-nav-link <?= $isActive ? 'active' : '' ?>">

                    <i class="bi <?= esc($item['icon']) ?>"></i>

                    <span><?= esc($item['label']) ?></span>

                </a>

            <?php endforeach; ?>

        </nav>

        <!-- INFORMASI PENGGUNA -->
        <div class="sip-sidebar-bottom">

            <div class="sip-profile-icon">
                <i class="bi bi-person"></i>
            </div>

            <div class="sip-profile-info">

                <strong>
                    <?= esc($nama) ?>
                </strong>

                <span>
                    <?= esc(ucfirst($role ?: 'Pengguna')) ?>
                </span>

            </div>

            <!-- TOMBOL LOGOUT -->
            <a href="#"
               class="sip-logout"
               title="Keluar"
               onclick="openLogoutModal(); return false;">

                <i class="bi bi-box-arrow-right"></i>

            </a>

        </div>

    </aside>

    <!-- KONTEN UTAMA -->
    <main class="sip-main">

        <div class="sip-content">

            <?= $this->include('layouts/notification') ?>

            <!-- KONTEN HALAMAN DITAMPILKAN DI SINI -->


<!-- MODAL KONFIRMASI LOGOUT -->
<div id="logoutModal" class="logout-modal">

    <div class="logout-modal-card">

        <div class="logout-modal-icon">
            <i class="bi bi-box-arrow-right"></i>
        </div>

        <h5>Konfirmasi Keluar</h5>

        <p>
            Apakah Anda yakin ingin keluar dari akun SIPEDOK?
        </p>

        <div class="logout-modal-actions">

            <button type="button" onclick="closeLogoutModal()">
                Batal
            </button>

            <a href="<?= site_url('logout') ?>">
                Ya, Keluar
            </a>

        </div>

    </div>

</div>

<style>
.logout-modal {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(20, 35, 55, .45);
    z-index: 100000;
    align-items: center;
    justify-content: center;
    padding: 15px;
}

.logout-modal.show {
    display: flex;
}

.logout-modal-card {
    background: #fff;
    width: min(380px, 100%);
    padding: 28px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(0,0,0,.16);
    animation: modalFade .25s ease;
}

.logout-modal-icon {
    width: 55px;
    height: 55px;
    margin: 0 auto 15px;
    border-radius: 50%;
    background: #eef3f8;
    color: #315b80;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 23px;
}

.logout-modal-card h5 {
    color: #263445;
    font-weight: 600;
    margin-bottom: 8px;
}

.logout-modal-card p {
    color: #718096;
    font-size: 13px;
    margin-bottom: 22px;
}

.logout-modal-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.logout-modal-actions button,
.logout-modal-actions a {
    padding: 9px 18px;
    border-radius: 7px;
    font-size: 13px;
    text-decoration: none;
    cursor: pointer;
}

.logout-modal-actions button {
    border: 1px solid #d9e0e8;
    background: white;
    color: #526174;
}

.logout-modal-actions a {
    border: 1px solid #315b80;
    background: #315b80;
    color: white;
}

.logout-modal-actions a:hover {
    background: #254765;
    color: white;
}

@keyframes modalFade {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
function openLogoutModal() {
    const modal = document.getElementById('logoutModal');

    if (modal) {
        modal.classList.add('show');
    }
}

function closeLogoutModal() {
    const modal = document.getElementById('logoutModal');

    if (modal) {
        modal.classList.remove('show');
    }
}

// Tutup modal jika klik area luar card
document.addEventListener('click', function(event) {
    const modal = document.getElementById('logoutModal');

    if (modal && event.target === modal) {
        closeLogoutModal();
    }
});

// Tutup modal dengan tombol Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeLogoutModal();
    }
});
</script>
