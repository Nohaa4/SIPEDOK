
<?= $this->include('layouts/header') ?>

<?php
$dokumen = $dokumen ?? [];

$laporan = $laporan ?? [];

$activeTab = $activeTab ?? 'form';

$bulan = [
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];
?>

<style>
/* ==========================================
   HALAMAN PELAPORAN DOKUMEN
========================================== */

.pelaporan-page {
    color: #243b53;
}

.pelaporan-heading {
    margin-bottom: 22px;
}

.pelaporan-heading h5 {
    font-size: 17px;
    font-weight: 700;
    color: #183b59;
    margin-bottom: 6px;
}

.pelaporan-heading p {
    color: #718096;
    font-size: 13px;
    margin: 0;
}

/* TAB NAVIGATION */

.pelaporan-tabs {
    display: flex;
    gap: 0;
    border-bottom: 1px solid #dfe6ec;
    margin-bottom: 22px;
}

.pelaporan-tab {
    border: none;
    background: transparent;
    color: #758497;
    font-size: 13px;
    font-weight: 600;
    padding: 13px 22px;
    border-bottom: 2px solid transparent;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: .2s;
}

.pelaporan-tab:hover {
    color: #159b9d;
}

.pelaporan-tab.active {
    color: #159b9d;
    border-bottom-color: #159b9d;
}

/* PANEL */

.pelaporan-panel {
    background: #fff;
    border: 1px solid #e8edf2;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 22px;
}

.pelaporan-panel h6 {
    color: #183b59;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 5px;
}

.pelaporan-panel .panel-desc {
    font-size: 12px;
    color: #8190a0;
    margin-bottom: 22px;
}

/* FORM */

.pelaporan-page .form-label {
    font-size: 12px;
    font-weight: 600;
    color: #40566c;
    margin-bottom: 7px;
}

.pelaporan-page .form-control,
.pelaporan-page .form-select {
    min-height: 42px;
    font-size: 13px;
    border-color: #dfe6ec;
    border-radius: 7px;
}

.pelaporan-page .form-control:focus,
.pelaporan-page .form-select:focus {
    border-color: #159b9d;
    box-shadow: 0 0 0 3px rgba(21,155,157,.10);
}

/* BUTTON */

.btn-kirim {
    background: #168f98;
    color: #fff;
    border: none;
    border-radius: 7px;
    padding: 10px 20px;
    font-size: 13px;
    font-weight: 600;
    transition: .2s;
}

.btn-kirim:hover {
    background: #117b83;
    color: #fff;
}

/* INFORMATION */

.pelaporan-info {
    background: #f0f8fa;
    border: 1px solid #dceef0;
    padding: 13px 15px;
    border-radius: 8px;
    color: #52717c;
    font-size: 12px;
    line-height: 1.7;
}

/* TABLE */

.pelaporan-table {
    font-size: 12px;
    vertical-align: middle;
    margin-bottom: 0;
}

.pelaporan-table thead th {
    background: #f5f8fa;
    color: #52677b;
    font-weight: 650;
    padding: 13px 12px;
    white-space: nowrap;
    border-bottom: 1px solid #e8edf2;
}

.pelaporan-table tbody td {
    padding: 13px 12px;
    color: #52677b;
    border-color: #edf0f3;
}

.pelaporan-table tbody tr:hover {
    background: #fafcfd;
}

/* STATUS */

.status-badge {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.status-menunggu {
    background: #fff5df;
    color: #a87518;
}

.status-diterima {
    background: #e4f6ee;
    color: #21845b;
}

.status-ditolak {
    background: #fdeaea;
    color: #c34d4d;
}

.status-sudah {
    background: #e4f6ee;
    color: #21845b;
}

.status-belum {
    background: #fff5df;
    color: #a87518;
}

.pembetulan-label {
    display: inline-block;
    background: #edf4f8;
    color: #42647d;
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

/* TAB CONTENT */

.pelaporan-tab-content {
    display: none;
}

.pelaporan-tab-content.active {
    display: block;
}

/* RESPONSIVE */

@media(max-width: 768px) {
    .pelaporan-panel {
        padding: 17px;
    }

    .pelaporan-tab {
        padding: 12px 14px;
        font-size: 12px;
    }
}
</style>


<div class="pelaporan-page">

    <!-- JUDUL HALAMAN -->

    <div class="pelaporan-heading">
        <h5>Pelaporan Dokumen</h5>
        <p>
            Kelola pelaporan dokumen kepegawaian melalui tautan OneDrive.
        </p>
    </div>


    <!-- NOTIFIKASI -->

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success small">
            <i class="bi bi-check-circle me-1"></i>
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger small">
            <i class="bi bi-exclamation-circle me-1"></i>
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>


    <!-- TAB MENU -->

    <div class="pelaporan-tabs">

        <button
            type="button"
            class="pelaporan-tab <?= $activeTab === 'form' ? 'active' : '' ?>"
            data-tab="form">

            <i class="bi bi-file-earmark-plus"></i>
            Form Pelaporan

        </button>

        <button
            type="button"
            class="pelaporan-tab <?= $activeTab === 'riwayat' ? 'active' : '' ?>"
            data-tab="riwayat">

            <i class="bi bi-clock-history"></i>
            Riwayat Pelaporan

        </button>

    </div>


    <!-- ======================================
         TAB 1: FORM PELAPORAN
    ======================================= -->

    <div
        id="tab-form"
        class="pelaporan-tab-content <?= $activeTab === 'form' ? 'active' : '' ?>">

        <div class="pelaporan-panel">

            <h6>Formulir Pelaporan Dokumen</h6>

            <p class="panel-desc">
                Lengkapi informasi dokumen yang akan dilaporkan.
            </p>


            <form
                action="<?= base_url('pegawai/pelaporan/simpan') ?>"
                method="post">

                <?= csrf_field() ?>


                <div class="row g-3">

                    <!-- JENIS DOKUMEN -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Jenis Dokumen
                        </label>

                        <select
                            name="kode_dokumen"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih jenis dokumen
                            </option>

                            <?php foreach ($dokumen as $kode => $nama): ?>

                                <option
                                    value="<?= esc($kode) ?>"
                                    <?= old('kode_dokumen') === $kode ? 'selected' : '' ?>>

                                    <?= esc($kode) ?> -
                                    <?= esc($nama) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- TAHUN DOKUMEN -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Tahun Dokumen
                        </label>

                        <select
                            name="tahun"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih tahun dokumen
                            </option>

                            <?php for ($tahun = 2023; $tahun <= 2029; $tahun++): ?>

                                <option
                                    value="<?= $tahun ?>"
                                    <?= old('tahun') == $tahun ? 'selected' : '' ?>>

                                    <?= $tahun ?>

                                </option>

                            <?php endfor; ?>

                        </select>

                    </div>


                    <!-- PERIODE -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Periode Dokumen
                        </label>

                        <select
                            name="periode"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih periode dokumen
                            </option>

                            <optgroup label="Bulanan">

                                <?php foreach ($bulan as $namaBulan): ?>

                                    <option
                                        value="<?= esc($namaBulan) ?>"
                                        <?= old('periode') === $namaBulan ? 'selected' : '' ?>>

                                        <?= esc($namaBulan) ?>

                                    </option>

                                <?php endforeach; ?>

                            </optgroup>

                            <optgroup label="Triwulan">

                                <?php for ($i = 1; $i <= 4; $i++): ?>

                                    <option
                                        value="Triwulan <?= $i ?>"
                                        <?= old('periode') === "Triwulan $i" ? 'selected' : '' ?>>

                                        Triwulan <?= $i ?>

                                    </option>

                                <?php endfor; ?>

                            </optgroup>

                            <option
                                value="Tahunan"
                                <?= old('periode') === 'Tahunan' ? 'selected' : '' ?>>

                                Tahunan

                            </option>

                        </select>

                    </div>


                    <!-- LINK ONEDRIVE -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Link Dokumen OneDrive
                        </label>

                        <input
                            type="url"
                            name="link_onedrive"
                            class="form-control"
                            placeholder="https://1drv.ms/..."
                            value="<?= esc(old('link_onedrive') ?? '') ?>"
                            required>

                    </div>


                    <!-- STATUS PENGESAHAN -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Status Pengesahan
                        </label>

                        <select
                            name="status_pengesahan"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih status pengesahan
                            </option>

                            <option
                                value="Sudah Disahkan"
                                <?= old('status_pengesahan') === 'Sudah Disahkan' ? 'selected' : '' ?>>

                                Sudah Disahkan

                            </option>

                            <option
                                value="Belum Disahkan"
                                <?= old('status_pengesahan') === 'Belum Disahkan' ? 'selected' : '' ?>>

                                Belum Disahkan

                            </option>

                        </select>

                    </div>


                    <!-- PEMBETULAN -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Pembetulan
                        </label>

                        <select
                            name="pembetulan"
                            class="form-select"
                            required>

                            <option value="">
                                Pilih pembetulan
                            </option>

                            <?php for ($i = 0; $i <= 4; $i++): ?>

                                <option
                                    value="<?= $i ?>"
                                    <?= old('pembetulan') !== null &&
                                        (string) old('pembetulan') === (string) $i
                                        ? 'selected'
                                        : '' ?>>

                                    Pembetulan <?= $i ?>

                                    <?= $i === 0 ? '(Dokumen Awal)' : '' ?>

                                </option>

                            <?php endfor; ?>

                        </select>

                        <small class="text-muted">
                            Pilih 0 untuk dokumen awal atau 1–4
                            sesuai tingkat pembetulan.
                        </small>

                    </div>


                    <!-- INFORMASI -->

                    <div class="col-12">

                        <div class="pelaporan-info">

                            <i class="bi bi-info-circle me-1"></i>

                            Pastikan tautan OneDrive dapat diakses oleh
                            pihak yang melakukan verifikasi. Atur izin
                            berbagi tautan sesuai ketentuan direktorat.

                        </div>

                    </div>


                    <!-- TOMBOL KIRIM -->

                    <div class="col-12 d-flex justify-content-end">

                        <button
                            type="submit"
                            class="btn-kirim">

                            <i class="bi bi-send me-1"></i>
                            Kirim Laporan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- ======================================
         TAB 2: RIWAYAT PELAPORAN
    ======================================= -->

    <div
        id="tab-riwayat"
        class="pelaporan-tab-content <?= $activeTab === 'riwayat' ? 'active' : '' ?>">

        <div class="pelaporan-panel">

            <h6>Riwayat Pelaporan Dokumen</h6>

            <p class="panel-desc">
                Daftar dokumen yang sudah pernah kamu laporkan.
            </p>


            <div class="table-responsive">

                <table class="table pelaporan-table">

                    <thead>

                        <tr>
                            <th>No.</th>
                            <th>Jenis Dokumen</th>
                            <th>Tahun</th>
                            <th>Periode</th>
                            <th>Pembetulan</th>
                            <th>Pengesahan</th>
                            <th>Status Verifikasi</th>
                            <th>Dokumen</th>
                        </tr>

                    </thead>


                    <tbody>

                        <?php if (!empty($laporan)): ?>

                            <?php foreach ($laporan as $i => $item): ?>

                                <tr>

                                    <!-- NOMOR -->

                                    <td>
                                        <?= $i + 1 ?>
                                    </td>


                                    <!-- JENIS DOKUMEN -->

                                    <td>

                                        <strong>
                                            <?= esc($item['kode_dokumen']) ?>
                                        </strong>

                                        <div>
                                            <?= esc($item['nama_dokumen']) ?>
                                        </div>

                                    </td>


                                    <!-- TAHUN -->

                                    <td>
                                        <?= esc($item['tahun']) ?>
                                    </td>


                                    <!-- PERIODE -->

                                    <td>
                                        <?= esc($item['periode']) ?>
                                    </td>


                                    <!-- PEMBETULAN -->

                                    <td>

                                        <span class="pembetulan-label">

                                            Pembetulan
                                            <?= esc($item['pembetulan']) ?>

                                        </span>

                                    </td>


                                    <!-- PENGESAHAN -->

                                    <td>

                                        <?php if ($item['status_pengesahan'] === 'Sudah Disahkan'): ?>

                                            <span class="status-badge status-sudah">
                                                Sudah Disahkan
                                            </span>

                                        <?php else: ?>

                                            <span class="status-badge status-belum">
                                                Belum Disahkan
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- STATUS VERIFIKASI -->

                                    <td>

                                        <?php
                                        $status = $item['status_verifikasi'] ?? 'Menunggu Verifikasi';

                                        $statusClass = 'status-menunggu';

                                        if ($status === 'Diterima') {
                                            $statusClass = 'status-diterima';
                                        } elseif ($status === 'Ditolak') {
                                            $statusClass = 'status-ditolak';
                                        }
                                        ?>

                                        <span class="status-badge <?= $statusClass ?>">

                                            <?= esc($status) ?>

                                        </span>

                                    </td>


                                    <!-- LINK DOKUMEN -->

                                    <td>

                                        <a
                                            href="<?= esc($item['link_onedrive']) ?>"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="text-decoration-none">

                                            <i class="bi bi-box-arrow-up-right"></i>
                                            Buka

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5 text-muted">

                                    <i class="bi bi-folder2-open fs-4 d-block mb-2"></i>

                                    Belum ada dokumen yang dilaporkan.

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<!-- ==========================================
     JAVASCRIPT TAB
========================================== -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabButtons = document.querySelectorAll('.pelaporan-tab');

    const tabContents = document.querySelectorAll('.pelaporan-tab-content');

    tabButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const target = this.dataset.tab;

            // Hilangkan status aktif dari semua tombol
            tabButtons.forEach(function (item) {
                item.classList.remove('active');
            });

            // Hilangkan status aktif dari semua konten
            tabContents.forEach(function (item) {
                item.classList.remove('active');
            });

            // Aktifkan tab yang dipilih
            this.classList.add('active');

            const targetContent = document.getElementById('tab-' + target);

            if (targetContent) {
                targetContent.classList.add('active');
            }

        });

    });

});
</script>


<?= $this->include('layouts/footer') ?>
