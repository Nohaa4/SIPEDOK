
<?= $this->include('layouts/header') ?>

<?php
$totalPegawai = (int) ($totalPegawai ?? 0);
$sudahMelapor = (int) ($sudahMelapor ?? 0);
$belumMelapor = (int) ($belumMelapor ?? 0);

$persentase = $totalPegawai > 0
    ? round(($sudahMelapor / $totalPegawai) * 100)
    : 0;

$persentase = min(100, max(0, $persentase));

$tahun = (int) ($tahun ?? date('Y'));
$periode = $periode ?? 'semua';
$jenis_dokumen = $jenis_dokumen ?? 'semua';

$namaPengguna = session()->get('nama') ?? 'Pengguna';

$rolePengguna = match (session()->get('role')) {
    'admin' => 'Admin',
    'pegawai' => 'Pegawai',
    'direktorat' => 'Direktorat',
    default => 'Pengguna'
};

$pilihanDokumen = [
    'A' => 'SKP Tahunan – Penetapan',
    'B' => 'SKP Periodik',
    'C' => 'SKP Tahunan – Penilaian',
    'D' => 'SKP Tahunan – Dokumen Evaluasi',
    'E' => 'Laporan Pekerjaan Pimpinan',
    'F' => 'PAK (1 Set 3 Dokumen) Tahunan',
    'G' => 'PAK Lainnya',
    'H' => 'BPE SPT Pajak – Coretax (di Simpeg)',
    'I' => 'SKP Tahunan Penetapan (SKP, di Simpeg)',
    'J' => 'SKP Tahunan Penilaian (PPK, di Simpeg)',
];
?>

<!-- NAVBAR -->
<nav class="sip-navbar">
    <div class="sip-navbar-left">
        <div class="sip-navbar-heading">
            <span class="sip-navbar-caption">
                SISTEM INFORMASI PELAPORAN DOKUMEN PEGAWAI
            </span>
            <h4>
                Selamat datang, <?= esc($rolePengguna) ?>!
            </h4>
        </div>
    </div>

    <div class="sip-navbar-right">
        <div class="sip-navbar-date">
            <i class="bi bi-calendar3"></i>
            <span><?= date('d/m/Y') ?></span>
        </div>

        <div class="sip-navbar-divider"></div>

        <div class="sip-navbar-profile">
            <div class="sip-navbar-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div class="sip-navbar-identity">
                <strong><?= esc($namaPengguna) ?></strong>
                <span><?= esc($rolePengguna) ?></span>
            </div>
        </div>
    </div>
</nav>


<!-- JUDUL DAN FILTER -->
<section class="dashboard-toolbar">

    <div class="dashboard-title">
        <h1>Dashboard</h1>
        <p>Pantau kemajuan pelaporan dokumen pegawai.</p>
    </div>

    <form action="<?= site_url('dashboard') ?>" method="get" class="filter-form">

        <div class="filter-field">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun" class="form-select">
                <?php foreach (range(2023, 2029) as $th): ?>
                    <option value="<?= $th ?>" <?= $tahun === $th ? 'selected' : '' ?>>
                        <?= $th ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-field">
            <label for="periode">Periode</label>
            <select name="periode" id="periode" class="form-select">
                <option value="semua" <?= $periode === 'semua' ? 'selected' : '' ?>>
                    Semua Periode
                </option>
                <option value="triwulan1" <?= $periode === 'triwulan1' ? 'selected' : '' ?>>
                    Triwulan I
                </option>
                <option value="triwulan2" <?= $periode === 'triwulan2' ? 'selected' : '' ?>>
                    Triwulan II
                </option>
                <option value="triwulan3" <?= $periode === 'triwulan3' ? 'selected' : '' ?>>
                    Triwulan III
                </option>
                <option value="triwulan4" <?= $periode === 'triwulan4' ? 'selected' : '' ?>>
                    Triwulan IV
                </option>
            </select>
        </div>

        <div class="filter-field filter-document">
            <label for="jenis_dokumen">Jenis Dokumen</label>
            <select name="jenis_dokumen" id="jenis_dokumen" class="form-select">
                <option value="semua" <?= $jenis_dokumen === 'semua' ? 'selected' : '' ?>>
                    Semua Jenis Dokumen
                </option>

                <?php foreach ($pilihanDokumen as $kode => $nama): ?>
                    <option value="<?= $kode ?>" <?= $jenis_dokumen === $kode ? 'selected' : '' ?>>
                        <?= $kode ?> - <?= esc($nama) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn-apply">
            <i class="bi bi-funnel"></i>
            Terapkan
        </button>
    </form>
</section>


<!-- RINGKASAN -->
<section class="summary-grid">

    <article class="summary-card">
        <div class="summary-top">
            <span>Total Pegawai</span>
            <span class="summary-icon icon-blue">
                <i class="bi bi-people-fill"></i>
            </span>
        </div>
        <div class="summary-number"><?= $totalPegawai ?></div>
        <p class="summary-note">Jumlah pegawai pada tahun terpilih</p>
    </article>

    <article class="summary-card">
        <div class="summary-top">
            <span>Sudah Melapor</span>
            <span class="summary-icon icon-green">
                <i class="bi bi-check-circle-fill"></i>
            </span>
        </div>
        <div class="summary-number"><?= $sudahMelapor ?></div>
        <p class="summary-note">Pegawai yang sudah melaporkan dokumen</p>
    </article>

    <article class="summary-card">
        <div class="summary-top">
            <span>Belum Melapor</span>
            <span class="summary-icon icon-orange">
                <i class="bi bi-exclamation-circle-fill"></i>
            </span>
        </div>
        <div class="summary-number"><?= $belumMelapor ?></div>
        <p class="summary-note">Pegawai yang belum melaporkan dokumen</p>
    </article>

    <article class="summary-card">
        <div class="summary-top">
            <span>Kemajuan Pelaporan</span>
            <span class="summary-icon icon-purple">
                <i class="bi bi-graph-up-arrow"></i>
            </span>
        </div>
        <div class="summary-number">
            <?= $persentase ?><small>%</small>
        </div>
        <div class="summary-progress">
            <div style="width: <?= $persentase ?>%"></div>
        </div>
        <p class="summary-note">Persentase pelaporan dokumen</p>
    </article>

</section>


<!-- GRAFIK DAN MONITORING -->
<section class="dashboard-grid">

    <article class="panel">
        <div class="panel-heading">
            <div>
                <h2>
                    <i class="bi bi-bar-chart-line-fill"></i>
                    Jumlah Pegawai per Tahun
                </h2>
                <p>Jumlah pegawai berdasarkan riwayat direktorat.</p>
            </div>
            <span class="chart-label">Jumlah pegawai</span>
        </div>

        <div class="chart-container">
            <canvas id="employeeChart"></canvas>
        </div>

        <div class="chart-info">
            <i class="bi bi-info-circle"></i>
            Grafik akan terisi setelah data dihubungkan.
        </div>
    </article>


    <article class="panel">
        <div class="panel-heading">
            <div>
                <h2>
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    Kemajuan per Jenis Dokumen
                </h2>
                <p>Persentase pegawai yang sudah melapor.</p>
            </div>

            <a href="<?= site_url('monitoring-dokumen') ?>" class="view-all">
                Lihat semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="document-list">
            <?php foreach (array_slice($dokumen ?? [], 0, 4) as $item): ?>

                <?php
                    $total = (int) ($item['total'] ?? 0);
                    $melapor = (int) ($item['melapor'] ?? 0);

                    $persen = $total > 0
                        ? round(($melapor / $total) * 100)
                        : 0;

                    $persen = min(100, max(0, $persen));

                    if ($persen <= 30) {
                        $warna = 'progress-red';
                        $status = 'Rendah';
                    } elseif ($persen <= 70) {
                        $warna = 'progress-yellow';
                        $status = 'Sedang';
                    } elseif ($persen < 100) {
                        $warna = 'progress-green';
                        $status = 'Hampir selesai';
                    } else {
                        $warna = 'progress-blue';
                        $status = 'Selesai';
                    }
                ?>

                <div class="document-item">
                    <div class="document-heading">
                        <div class="document-title">
                            <span class="document-code">
                                <?= esc($item['kode'] ?? '-') ?>
                            </span>
                            <span class="document-name">
                                <?= esc($item['nama'] ?? '-') ?>
                            </span>
                        </div>
                        <strong class="document-percentage">
                            <?= $persen ?>%
                        </strong>
                    </div>

                    <div class="progress-track">
                        <div
                            class="progress-bar-custom <?= $warna ?>"
                            style="width: <?= $persen ?>%">
                        </div>
                    </div>

                    <div class="document-progress-info">
                        <span><?= $melapor ?> dari <?= $total ?> pegawai</span>
                        <span class="<?= $warna ?>-text"><?= $status ?></span>
                    </div>
                </div>

            <?php endforeach; ?>

            <?php if (empty($dokumen)): ?>
                <div class="document-empty">
                    Belum ada data pelaporan dokumen.
                </div>
            <?php endif; ?>
        </div>
    </article>

</section>


<footer class="page-footer">
    SIPEDOK <span>·</span> Sistem Informasi Pelaporan Dokumen Pegawai
</footer>

<?= $this->include('layouts/footer') ?>
