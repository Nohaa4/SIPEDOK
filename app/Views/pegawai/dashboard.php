<?= $this->include('layouts/header') ?>

<?php
$namaPengguna = session()->get('nama') ?? 'Pegawai';
$rolePengguna = 'Pegawai';

$dokumen = $dokumen ?? [
    ['kode' => 'A', 'nama' => 'SKP Tahunan – Penetapan'],
    ['kode' => 'B', 'nama' => 'SKP Periodik'],
    ['kode' => 'C', 'nama' => 'SKP Tahunan – Penilaian'],
    ['kode' => 'D', 'nama' => 'SKP Tahunan – Dokumen Evaluasi'],
    ['kode' => 'E', 'nama' => 'Laporan Pekerjaan Pimpinan'],
    ['kode' => 'F', 'nama' => 'PAK (1 Set 3 Dokumen) Tahunan'],
    ['kode' => 'G', 'nama' => 'PAK Lainnya'],
    ['kode' => 'H', 'nama' => 'BPE SPT Pajak – Coretax'],
    ['kode' => 'I', 'nama' => 'SKP Tahunan Penetapan (SKP)'],
    ['kode' => 'J', 'nama' => 'SKP Tahunan Penilaian (PPK)'],
];

$totalDokumen = count($dokumen);
$sudahDilaporkan = (int) ($sudahDilaporkan ?? 0);
$belumDilaporkan = max(0, $totalDokumen - $sudahDilaporkan);
$persentase = $totalDokumen > 0
    ? round(($sudahDilaporkan / $totalDokumen) * 100)
    : 0;

$tahun = $tahun ?? date('Y');
?>

<style>
.pegawai-page {
    color: #183b59;
}

.pegawai-welcome {
    background: #fff;
    border: 1px solid #e8edf2;
    border-radius: 12px;
    padding: 17px 22px;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.pegawai-welcome small {
    display: block;
    color: #168c9a;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1px;
    margin-bottom: 5px;
}

.pegawai-welcome h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #183b59;
}

.pegawai-welcome p {
    margin: 5px 0 0;
    color: #718096;
    font-size: 12px;
}

.pegawai-profile {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pegawai-avatar {
    width: 39px;
    height: 39px;
    border-radius: 50%;
    background: #e8f4f5;
    color: #168c9a;
    display: grid;
    place-items: center;
    font-size: 18px;
}

.pegawai-profile strong {
    display: block;
    font-size: 12px;
}

.pegawai-profile span {
    display: block;
    color: #8995a3;
    font-size: 11px;
    margin-top: 3px;
}

.pegawai-heading {
    display: flex;
    justify-content: space-between;
    align-items: end;
    gap: 15px;
    margin-bottom: 18px;
}

.pegawai-heading h3 {
    font-size: 21px;
    font-weight: 700;
    margin: 0 0 5px;
}

.pegawai-heading p {
    color: #718096;
    font-size: 12px;
    margin: 0;
}

.pegawai-filter {
    min-width: 125px;
    border: 1px solid #dce5ec;
    border-radius: 7px;
    padding: 8px 12px;
    color: #183b59;
    font-size: 12px;
    background: #fff;
}

.pegawai-summary {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 15px;
    margin-bottom: 21px;
}

.pegawai-card {
    background: #fff;
    border: 1px solid #e6edf2;
    border-radius: 12px;
    padding: 19px;
    min-height: 145px;
    box-shadow: 0 3px 12px rgba(25, 55, 80, .035);
    position: relative;
    overflow: hidden;
}

.pegawai-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #258bd5;
}

.pegawai-card.success::before { background: #35a77d; }
.pegawai-card.warning::before { background: #f39a3c; }
.pegawai-card.teal::before { background: #159b9d; }

.pegawai-card-label {
    color: #526b83;
    font-size: 12px;
}

.pegawai-card-number {
    display: block;
    font-size: 28px;
    font-weight: 700;
    margin-top: 15px;
    line-height: 1.2;
    color: #183b59;
}

.pegawai-card.success .pegawai-card-number { color: #35a77d; }
.pegawai-card.warning .pegawai-card-number { color: #f39a3c; }
.pegawai-card.teal .pegawai-card-number { color: #159b9d; }

.pegawai-card-note {
    display: block;
    color: #8995a3;
    font-size: 10px;
    margin-top: 8px;
}

.pegawai-progress {
    height: 7px;
    background: #e9eef3;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 13px;
}

.pegawai-progress > div {
    height: 100%;
    background: #159b9d;
    border-radius: 10px;
}

.pegawai-panel {
    background: #fff;
    border: 1px solid #e6edf2;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 3px 12px rgba(25, 55, 80, .035);
    margin-bottom: 20px;
}

.pegawai-panel-title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 17px;
}

.pegawai-panel-title h5 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #183b59;
}

.pegawai-panel-title p {
    margin: 5px 0 0;
    color: #8995a3;
    font-size: 11px;
}

.pegawai-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}

.pegawai-table th {
    color: #718096;
    font-weight: 600;
    background: #f7f9fb;
    padding: 12px 10px;
    text-align: left;
    white-space: nowrap;
}

.pegawai-table td {
    padding: 13px 10px;
    border-bottom: 1px solid #edf1f4;
    color: #354f67;
    vertical-align: middle;
}

.pegawai-table tr:last-child td {
    border-bottom: 0;
}

.pegawai-code {
    display: inline-grid;
    place-items: center;
    width: 27px;
    height: 27px;
    border-radius: 7px;
    background: #e8f5f4;
    color: #159b9d;
    font-weight: 700;
}

.pegawai-status {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
}

.pegawai-status.belum {
    color: #c47a20;
    background: #fff2df;
}

.pegawai-status.sudah {
    color: #21845e;
    background: #e4f5ed;
}

.pegawai-action {
    display: inline-block;
    background: #176b83;
    color: #fff;
    text-decoration: none;
    padding: 7px 11px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.pegawai-action:hover {
    color: #fff;
    background: #12566b;
}

.pegawai-empty {
    text-align: center;
    padding: 25px 10px;
    color: #8995a3;
    font-size: 12px;
}

@media (max-width: 1100px) {
    .pegawai-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}

@media (max-width: 650px) {
    .pegawai-welcome,
    .pegawai-heading {
        align-items: flex-start;
        flex-direction: column;
    }

    .pegawai-summary { grid-template-columns: 1fr 1fr; }
    .pegawai-panel { padding: 14px; }
    .pegawai-table { min-width: 600px; }
    .pegawai-table-wrap { overflow-x: auto; }
}
</style>

<div class="pegawai-page">

    <!-- Navbar Pegawai -->
    <div class="pegawai-welcome">
        <div>
            <small>SISTEM INFORMASI PELAPORAN DOKUMEN PEGAWAI</small>
            <h4>Selamat datang, Pegawai!</h4>
            <p>Pantau dan kelola pelaporan dokumen pribadi Anda.</p>
        </div>

        <div class="pegawai-profile">
            <div class="pegawai-avatar">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <strong><?= esc($namaPengguna) ?></strong>
                <span><?= esc($rolePengguna) ?></span>
            </div>
        </div>
    </div>

    <!-- Judul dan Filter -->
    <div class="pegawai-heading">
        <div>
            <h3>Dashboard</h3>
            <p>Ringkasan status pelaporan dokumen Anda.</p>
        </div>

        <form method="get" action="<?= current_url() ?>">
            <select name="tahun" class="pegawai-filter" onchange="this.form.submit()">
                <?php for ($y = 2023; $y <= 2029; $y++): ?>
                    <option value="<?= $y ?>" <?= (int) $tahun === $y ? 'selected' : '' ?>>
                        <?= $y ?>
                    </option>
                <?php endfor; ?>
            </select>
        </form>
    </div>

    <!-- Ringkasan -->
    <div class="pegawai-summary">
        <div class="pegawai-card">
            <span class="pegawai-card-label">Total Dokumen Wajib</span>
            <strong class="pegawai-card-number"><?= $totalDokumen ?></strong>
            <span class="pegawai-card-note">Dokumen yang perlu dilaporkan</span>
        </div>

        <div class="pegawai-card success">
            <span class="pegawai-card-label">Sudah Dilaporkan</span>
            <strong class="pegawai-card-number"><?= $sudahDilaporkan ?></strong>
            <span class="pegawai-card-note">Dokumen yang telah dikirim</span>
        </div>

        <div class="pegawai-card warning">
            <span class="pegawai-card-label">Belum Dilaporkan</span>
            <strong class="pegawai-card-number"><?= $belumDilaporkan ?></strong>
            <span class="pegawai-card-note">Dokumen yang belum dikirim</span>
        </div>

        <div class="pegawai-card teal">
            <span class="pegawai-card-label">Kelengkapan Pelaporan</span>
            <strong class="pegawai-card-number"><?= $persentase ?>%</strong>
            <div class="pegawai-progress">
                <div style="width: <?= $persentase ?>%"></div>
            </div>
            <span class="pegawai-card-note">Persentase dokumen yang dilaporkan</span>
        </div>
    </div>

    <!-- Status Dokumen -->
    <div class="pegawai-panel">
        <div class="pegawai-panel-title">
            <div>
                <h5><i class="bi bi-file-earmark-check me-2 text-info"></i>Status Pelaporan Dokumen</h5>
                <p>Daftar dokumen yang menjadi kewajiban pelaporan Anda.</p>
            </div>

            <a href="<?= site_url('pegawai/pelaporan') ?>" class="pegawai-action">
                Lihat Pelaporan <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="pegawai-table-wrap">
            <table class="pegawai-table">
                <thead>
                    <tr>
                        <th width="65">Kode</th>
                        <th>Jenis Dokumen</th>
                        <th>Status Pelaporan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dokumen as $item): ?>
                        <?php
                        $status = $item['status'] ?? 'belum';
                        $sudah = in_array($status, ['sudah', 'menunggu', 'terverifikasi'], true);
                        ?>
                        <tr>
                            <td>
                                <span class="pegawai-code"><?= esc($item['kode']) ?></span>
                            </td>
                            <td><?= esc($item['nama']) ?></td>
                            <td>
                                <?php if ($sudah): ?>
                                    <span class="pegawai-status sudah">
                                        <i class="bi bi-check-circle me-1"></i>
                                        <?= esc(ucfirst($status)) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="pegawai-status belum">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        Belum Dilaporkan
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="pegawai-action"
                                   href="<?= site_url('pegawai/pelaporan') ?>">
                                    <?= $sudah ? 'Lihat Detail' : 'Laporkan' ?>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Informasi -->
    <div class="pegawai-panel">
        <div class="pegawai-panel-title">
            <div>
                <h5><i class="bi bi-info-circle me-2 text-info"></i>Informasi Pelaporan</h5>
                <p>Perhatikan hal-hal berikut sebelum mengirimkan dokumen.</p>
            </div>
        </div>

        <div class="d-flex gap-3 align-items-start">
            <i class="bi bi-cloud-arrow-up text-info fs-4"></i>
            <div>
                <strong class="d-block mb-1" style="font-size:12px;">Gunakan Link OneDrive</strong>
                <span style="font-size:11px;color:#718096;">
                    Pastikan link dokumen OneDrive dapat diakses oleh pihak yang berwenang sebelum dikirimkan.
                </span>
            </div>
        </div>
    </div>

</div>

<?= $this->include('layouts/footer') ?>