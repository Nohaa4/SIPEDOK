```php
<?= $this->include('layouts/header') ?>

<style>
.tindak-page {
    padding: 28px;
    background: #f4f7fb;
    min-height: calc(100vh - 70px);
    color: #173653;
}

.tindak-heading {
    margin-bottom: 24px;
}

.tindak-eyebrow {
    color: #7188a2;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    margin-bottom: 8px;
}

.tindak-heading h1 {
    font-size: 29px;
    font-weight: 750;
    margin: 0 0 7px;
    color: #153653;
}

.tindak-heading p {
    color: #7a8fa7;
    font-size: 13px;
    margin: 0;
}

.tindak-summary {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}

.tindak-stat {
    background: #fff;
    border: 1px solid #e0e8f0;
    border-radius: 8px;
    padding: 20px;
}

.tindak-stat-label {
    color: #758aa0;
    font-size: 12px;
    margin-bottom: 12px;
}

.tindak-stat-value {
    color: #173653;
    font-size: 28px;
    font-weight: 750;
    line-height: 1;
    margin-bottom: 9px;
}

.tindak-stat-note {
    color: #8799ac;
    font-size: 11px;
}

.tindak-stat-value.red {
    color: #cf4d55;
}

.tindak-stat-value.green {
    color: #25875c;
}

.tindak-panel {
    background: #fff;
    border: 1px solid #e0e8f0;
    border-radius: 9px;
    padding: 22px 20px;
    box-shadow: 0 2px 8px rgba(24, 55, 84, .025);
}

.tindak-panel-heading {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.tindak-panel-heading h2 {
    color: #183b59;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 7px;
}

.tindak-panel-heading p {
    color: #8295aa;
    font-size: 11px;
    margin: 0;
}

.tindak-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
}

.tindak-filters input,
.tindak-filters select {
    height: 38px;
    padding: 0 11px;
    border: 1px solid #d6e0eb;
    border-radius: 5px;
    color: #294765;
    background: #fff;
    font-size: 12px;
}

.tindak-filters input {
    flex: 1;
    min-width: 190px;
}

.tindak-filters select {
    min-width: 145px;
}

.tindak-table-wrap {
    overflow-x: auto;
}

.tindak-table {
    width: 100%;
    min-width: 750px;
    border-collapse: collapse;
    font-size: 12px;
}

.tindak-table thead {
    background: #f1f5f8;
}

.tindak-table th {
    padding: 13px 12px;
    text-align: left;
    color: #58718b;
    font-size: 10px;
    font-weight: 600;
    border-bottom: 1px solid #e1e9f0;
}

.tindak-table td {
    padding: 14px 12px;
    color: #3d5b78;
    border-bottom: 1px solid #e7edf3;
    vertical-align: middle;
}

.tindak-table tbody tr:hover {
    background: #fafcff;
}

.tindak-name {
    font-weight: 600;
    color: #244563;
}

.tindak-subtext {
    display: block;
    color: #899bad;
    font-size: 10px;
    margin-top: 4px;
}

.tindak-status {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 10px;
    white-space: nowrap;
}

.tindak-status::before {
    content: "";
    display: inline-block;
    width: 5px;
    height: 5px;
    border-radius: 50%;
    margin-right: 6px;
    vertical-align: middle;
    background: currentColor;
}

.tindak-status-belum {
    color: #c7464e;
    background: #ffebec;
}

.tindak-status-sudah {
    color: #21865a;
    background: #e5f6ed;
}

.tindak-status-periksa {
    color: #b77816;
    background: #fff3df;
}

.tindak-action {
    border: 1px solid #c5d8eb;
    color: #315e86;
    background: #fff;
    padding: 7px 10px;
    border-radius: 5px;
    font-size: 10px;
    cursor: pointer;
}

.tindak-action:hover {
    background: #edf5fc;
}

.tindak-empty {
    text-align: center;
    padding: 30px !important;
    color: #8295aa !important;
}

.tindak-footer {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    padding-top: 16px;
    color: #8295aa;
    font-size: 11px;
}

.tindak-info {
    background: #edf6ff;
    border: 1px solid #d6e7f8;
    color: #52728f;
    border-radius: 6px;
    padding: 12px 14px;
    font-size: 11px;
    line-height: 1.6;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .tindak-page {
        padding: 18px 12px;
    }

    .tindak-heading h1 {
        font-size: 24px;
    }

    .tindak-summary {
        grid-template-columns: 1fr;
        gap: 10px;
    }

    .tindak-stat {
        padding: 16px;
    }

    .tindak-panel {
        padding: 16px 12px;
    }

    .tindak-filters {
        flex-direction: column;
    }

    .tindak-filters input,
    .tindak-filters select {
        width: 100%;
        min-width: 0;
    }
}
</style>

<?php
$contohTindakLanjut = [
    [
        'nama' => 'Andi Saputra',
        'nip' => 'Contoh data pegawai',
        'dokumen' => 'SKP Tahunan – Penetapan',
        'tahun' => 2026,
        'status' => 'belum',
    ],
    [
        'nama' => 'Budi Santoso',
        'nip' => 'Contoh data pegawai',
        'dokumen' => 'PAK Tahunan',
        'tahun' => 2026,
        'status' => 'sudah',
    ],
    [
        'nama' => 'Citra Amelia',
        'nip' => 'Contoh data pegawai',
        'dokumen' => 'SKP Periodik',
        'tahun' => 2026,
        'status' => 'periksa',
    ],
    [
        'nama' => 'Dedi Firmansyah',
        'nip' => 'Contoh data pegawai',
        'dokumen' => 'Dokumen Evaluasi',
        'tahun' => 2026,
        'status' => 'belum',
    ],
];

$totalBelum = 0;
$totalSudah = 0;
$totalPeriksa = 0;

foreach ($contohTindakLanjut as $item) {
    if ($item['status'] === 'belum') {
        $totalBelum++;
    } elseif ($item['status'] === 'sudah') {
        $totalSudah++;
    } else {
        $totalPeriksa++;
    }
}
?>

<div class="tindak-page">
    <div class="tindak-heading">
        <div class="tindak-eyebrow">PENGELOLAAN DOKUMEN</div>
        <h1>Tindak Lanjut</h1>
        <p>Pantau dokumen yang belum ditandatangani dan perlu diperiksa.</p>
    </div>
    
    <div class="tindak-summary">
        <div class="tindak-stat">
            <div class="tindak-stat-label">Belum Tanda Tangan</div>
            <div class="tindak-stat-value red"><?= $totalBelum ?></div>
            <div class="tindak-stat-note">Dokumen dalam data contoh</div>
        </div>

        <div class="tindak-stat">
            <div class="tindak-stat-label">Sudah Tanda Tangan</div>
            <div class="tindak-stat-value green"><?= $totalSudah ?></div>
            <div class="tindak-stat-note">Dokumen dalam data contoh</div>
        </div>

        <div class="tindak-stat">
            <div class="tindak-stat-label">Perlu Diperiksa</div>
            <div class="tindak-stat-value"><?= $totalPeriksa ?></div>
            <div class="tindak-stat-note">Hasil deteksi belum dipastikan</div>
        </div>
    </div>

    <section class="tindak-panel">
        <div class="tindak-panel-heading">
            <div>
                <h2>Daftar Tindak Lanjut Dokumen</h2>
                <p>Gunakan pencarian dan filter untuk menemukan dokumen.</p>
            </div>
        </div>

        <div class="tindak-filters">
            <input type="search" id="cariTindak"
                   placeholder="Cari nama pegawai atau jenis dokumen...">

            <select id="filterTahun">
                <option value="">Semua Tahun</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
            </select>

            <select id="filterStatus">
                <option value="">Semua Status</option>
                <option value="belum">Belum TTD</option>
                <option value="sudah">Sudah TTD</option>
                <option value="periksa">Perlu diperiksa</option>
            </select>
        </div>

        <div class="tindak-table-wrap">
            <table class="tindak-table">
                <thead>
                    <tr>
                        <th>Nama Pegawai</th>
                        <th>Jenis Dokumen</th>
                        <th>Tahun</th>
                        <th>Status Tanda Tangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabelTindak">
                    <?php foreach ($contohTindakLanjut as $item): ?>
                        <?php
                        $label = [
                            'belum' => 'Belum TTD',
                            'sudah' => 'Sudah TTD',
                            'periksa' => 'Perlu diperiksa',
                        ][$item['status']];

                        $classStatus = [
                            'belum' => 'tindak-status-belum',
                            'sudah' => 'tindak-status-sudah',
                            'periksa' => 'tindak-status-periksa',
                        ][$item['status']];
                        ?>
                        <tr data-tahun="<?= $item['tahun'] ?>"
                            data-status="<?= esc($item['status']) ?>">
                            <td>
                                <span class="tindak-name"><?= esc($item['nama']) ?></span>
                                <span class="tindak-subtext"><?= esc($item['nip']) ?></span>
                            </td>
                            <td><?= esc($item['dokumen']) ?></td>
                            <td><?= esc((string) $item['tahun']) ?></td>
                            <td>
                                <span class="tindak-status <?= $classStatus ?>">
                                    <?= esc($label) ?>
                                </span>
                            </td>
                            <td>
                                <button type="button" class="tindak-action"
                                        onclick="alert('Fitur pemeriksaan PDF akan ditambahkan setelah tampilan selesai.')">
                                    Periksa dokumen
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr id="tindakKosong" style="display:none">
                        <td colspan="5" class="tindak-empty">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="tindak-footer">
            <span id="jumlahTampil">Menampilkan <?= count($contohTindakLanjut) ?> data contoh</span>
            <span>Status belum terhubung ke pemeriksaan PDF.</span>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cari = document.getElementById('cariTindak');
    const tahun = document.getElementById('filterTahun');
    const status = document.getElementById('filterStatus');
    const tabel = document.getElementById('tabelTindak');
    const baris = Array.from(tabel.querySelectorAll('tr[data-tahun]'));
    const kosong = document.getElementById('tindakKosong');
    const jumlah = document.getElementById('jumlahTampil');

    function filterData() {
        const kata = cari.value.toLowerCase().trim();
        const tahunPilih = tahun.value;
        const statusPilih = status.value;
        let terlihat = 0;

        baris.forEach(function (row) {
            const teks = row.textContent.toLowerCase();
            const cocokKata = teks.includes(kata);
            const cocokTahun = !tahunPilih || row.dataset.tahun === tahunPilih;
            const cocokStatus = !statusPilih || row.dataset.status === statusPilih;
            const tampil = cocokKata && cocokTahun && cocokStatus;

            row.style.display = tampil ? '' : 'none';

            if (tampil) terlihat++;
        });

        kosong.style.display = terlihat === 0 ? '' : 'none';
        jumlah.textContent = 'Menampilkan ' + terlihat + ' dari ' + baris.length + ' data contoh';
    }

    cari.addEventListener('input', filterData);
    tahun.addEventListener('change', filterData);
    status.addEventListener('change', filterData);
});
</script>

<?= $this->include('layouts/footer') ?>
```