
<?php
$pegawaiSudah = $pegawaiSudah ?? [];
$pegawaiBelum = $pegawaiBelum ?? [];

$totalSudah = count($pegawaiSudah);
$totalBelum = count($pegawaiBelum);
$totalPegawai = $totalSudah + $totalBelum;

$persentase = $totalPegawai > 0
    ? round(($totalSudah / $totalPegawai) * 100)
    : 0;

$namaDokumen = $namaDokumen ?? 'SKP Tahunan – Penetapan';
$tahun = $tahun ?? date('Y');
?>

<?= $this->include('layouts/header') ?>

<style>
.monitoring-detail {
    padding: 28px 30px;
    color: #193452;
}

.page-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    gap: 15px;
}

.page-heading h2 {
    font-size: 27px;
    font-weight: 700;
    margin: 5px 0;
}

.page-heading p {
    color: #8293a9;
    margin: 0;
    font-size: 13px;
}

.back-btn {
    border: 1px solid #cbd8e8;
    background: white;
    color: #234a75;
    padding: 10px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 13px;
}

.back-btn:hover {
    background: #edf3fa;
    color: #193452;
}

.document-info {
    background: white;
    border: 1px solid #dce5ef;
    border-radius: 9px;
    padding: 22px;
    margin-bottom: 20px;
}

.document-info h5 {
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 5px;
}

.document-info p {
    color: #8293a9;
    font-size: 13px;
    margin: 0;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 17px;
    margin-bottom: 22px;
}

.summary-box {
    background: white;
    border: 1px solid #dce5ef;
    border-radius: 9px;
    padding: 20px;
}

.summary-box .summary-label {
    font-size: 13px;
    color: #7b8da4;
}

.summary-box h3 {
    font-size: 28px;
    font-weight: 700;
    margin: 10px 0 0;
}

.summary-box small {
    font-size: 12px;
    color: #8a9bb0;
}

.green { color: #21965c; }
.red { color: #dc5353; }
.blue { color: #2869b1; }

.progress-area {
    margin-top: 16px;
}

.progress {
    height: 8px;
    background: #e8eef5;
    border-radius: 10px;
}

.progress-bar {
    background: #2784cf;
    border-radius: 10px;
}

.employee-card {
    background: white;
    border: 1px solid #dce5ef;
    border-radius: 9px;
    padding: 22px;
}

.employee-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.employee-header h5 {
    font-size: 17px;
    font-weight: 700;
    margin: 0 0 5px;
}

.employee-header p {
    font-size: 12px;
    color: #8796a9;
    margin: 0;
}

.filter-area {
    display: flex;
    gap: 10px;
    margin-bottom: 18px;
}

.filter-area input {
    max-width: 320px;
    border: 1px solid #d5dfeb;
    font-size: 13px;
    padding: 10px 13px;
    border-radius: 6px;
}

.nav-tabs {
    border-bottom: 1px solid #dce5ef;
    margin-bottom: 20px;
    gap: 20px;
}

.nav-tabs .nav-link {
    color: #71839a;
    border: none;
    padding: 12px 5px;
    font-size: 13px;
    font-weight: 600;
}

.nav-tabs .nav-link.active {
    color: #2869b1;
    border-bottom: 3px solid #2869b1;
    background: transparent;
}

.count-badge {
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 20px;
    margin-left: 5px;
}

.badge-green {
    background: #e2f5eb;
    color: #208451;
}

.badge-red {
    background: #fdeaea;
    color: #cf4545;
}

.employee-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.employee-table th {
    background: #f5f8fc;
    color: #73849b;
    font-weight: 600;
    padding: 13px;
    text-align: left;
    white-space: nowrap;
}

.employee-table td {
    padding: 14px 13px;
    border-bottom: 1px solid #e8edf3;
    color: #344b67;
}

.status-label {
    padding: 5px 11px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.status-done {
    color: #218451;
    background: #e2f5eb;
}

.status-pending {
    color: #cf4545;
    background: #fdeaea;
}

.pdf-btn {
    color: #2869b1;
    border: 1px solid #cbd9e9;
    padding: 6px 11px;
    text-decoration: none;
    border-radius: 5px;
    font-size: 12px;
}

.pdf-btn:hover {
    background: #edf4fb;
}

.empty-state {
    text-align: center;
    padding: 45px 15px !important;
    color: #91a0b2 !important;
}

@media(max-width: 768px) {
    .monitoring-detail { padding: 20px 14px; }
    .summary-grid { grid-template-columns: 1fr; }
    .page-heading, .employee-header {
        align-items: flex-start;
        flex-direction: column;
    }
    .filter-area { flex-direction: column; }
    .filter-area input { max-width: 100%; }
    .table-responsive { overflow-x: auto; }
}
</style>

<div class="monitoring-detail">

    <div class="page-heading">
        <div>
            <small style="color:#6684a8;font-weight:700;letter-spacing:1px">
                PENGELOLAAN DATA
            </small>
            <h2>Daftar Pegawai</h2>
            <p>Monitoring status pelaporan dokumen pegawai</p>
        </div>

        <a href="<?= site_url('monitoring-dokumen') ?>" class="back-btn">
            &larr; Kembali ke Monitoring
        </a>
    </div>

    <div class="document-info">
        <small style="color:#7890ac">JENIS DOKUMEN</small>
        <h5><?= esc($namaDokumen) ?></h5>
        <p>Tahun pelaporan <?= esc($tahun) ?></p>

        <div class="progress-area">
            <div class="d-flex justify-content-between mb-2">
                <small>Persentase pelaporan</small>
                <strong><?= $persentase ?>%</strong>
            </div>
            <div class="progress">
                <div class="progress-bar"
                     style="width:<?= $persentase ?>%">
                </div>
            </div>
        </div>
    </div>

    <div class="summary-grid">

        <div class="summary-box">
            <div class="summary-label">Total Pegawai</div>
            <h3 class="blue"><?= $totalPegawai ?></h3>
            <small>Jumlah pegawai dalam data</small>
        </div>

        <div class="summary-box">
            <div class="summary-label">Sudah Melaporkan</div>
            <h3 class="green"><?= $totalSudah ?></h3>
            <small>Pegawai telah mengirim dokumen</small>
        </div>

        <div class="summary-box">
            <div class="summary-label">Belum Melaporkan</div>
            <h3 class="red"><?= $totalBelum ?></h3>
            <small>Pegawai belum mengirim dokumen</small>
        </div>

    </div>

    <div class="employee-card">

        <div class="employee-header">
            <div>
                <h5>Daftar Status Pegawai</h5>
                <p>Pilih kategori untuk melihat daftar pelaporan pegawai.</p>
            </div>
        </div>

        <ul class="nav nav-tabs" role="tablist">

            <li class="nav-item">
                <button class="nav-link active"
                        data-bs-toggle="tab"
                        data-bs-target="#sudah"
                        type="button">
                    Sudah Melaporkan
                    <span class="count-badge badge-green">
                        <?= $totalSudah ?>
                    </span>
                </button>
            </li>

            <li class="nav-item">
                <button class="nav-link"
                        data-bs-toggle="tab"
                        data-bs-target="#belum"
                        type="button">
                    Belum Melaporkan
                    <span class="count-badge badge-red">
                        <?= $totalBelum ?>
                    </span>
                </button>
            </li>

        </ul>

        <div class="filter-area">
            <input type="text"
                   id="searchPegawai"
                   class="form-control"
                   placeholder="Cari nama atau NIP pegawai...">
        </div>

        <div class="tab-content">

            <!-- PEGAWAI SUDAH MELAPOR -->
            <div class="tab-pane fade show active" id="sudah">

                <div class="table-responsive">
                    <table class="employee-table">
                        <thead>
                            <tr>
                                <th width="60">No.</th>
                                <th>Nama Pegawai</th>
                                <th>NIP</th>
                                <th>Tanggal Lapor</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($pegawaiSudah)): ?>
                            <?php foreach ($pegawaiSudah as $i => $pegawai): ?>
                            <tr class="pegawai-row">
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($pegawai['nama'] ?? '-') ?></td>
                                <td><?= esc($pegawai['nip'] ?? '-') ?></td>
                                <td><?= esc($pegawai['tanggal_lapor'] ?? '-') ?></td>
                                <td>
                                    <span class="status-label status-done">
                                        Sudah Melapor
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($pegawai['file_url'])): ?>
                                    <a href="<?= esc($pegawai['file_url']) ?>"
                                       target="_blank"
                                       class="pdf-btn">
                                        Lihat PDF
                                    </a>
                                    <?php else: ?>
                                    <span style="color:#94a3b8">-</span>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    Belum ada pegawai yang melaporkan dokumen.
                                </td>
                            </tr>
                        <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- PEGAWAI BELUM MELAPOR -->
            <div class="tab-pane fade" id="belum">

                <div class="table-responsive">
                    <table class="employee-table">
                        <thead>
                            <tr>
                                <th width="60">No.</th>
                                <th>Nama Pegawai</th>
                                <th>NIP</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (!empty($pegawaiBelum)): ?>
                            <?php foreach ($pegawaiBelum as $i => $pegawai): ?>
                            <tr class="pegawai-row">
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($pegawai['nama'] ?? '-') ?></td>
                                <td><?= esc($pegawai['nip'] ?? '-') ?></td>
                                <td>
                                    <span class="status-label status-pending">
                                        Belum Melapor
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="empty-state">
                                    Semua pegawai telah melaporkan dokumen.
                                </td>
                            </tr>
                        <?php endif ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('searchPegawai').addEventListener('input', function() {
    const keyword = this.value.toLowerCase();

    const activeTab = document.querySelector('.tab-pane.active');

    if (!activeTab) return;

    activeTab.querySelectorAll('.pegawai-row').forEach(function(row) {
        row.style.display = row.innerText.toLowerCase().includes(keyword)
            ? ''
            : 'none';
    });
});

document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(tab) {
    tab.addEventListener('shown.bs.tab', function() {
        document.getElementById('searchPegawai').value = '';

        document.querySelectorAll('.pegawai-row').forEach(function(row) {
            row.style.display = '';
        });
    });
});
</script>

<?= $this->include('layouts/footer') ?>
