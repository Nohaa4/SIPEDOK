
<?= $this->include('layouts/header') ?>

<header class="page-header">
    <div class="page-heading">
        <h1>Tindak Lanjut</h1>
        <p>Periksa dan pantau validitas tanda tangan digital dokumen pegawai.</p>
    </div>
</header>

<?php
$jumlahValid = count(array_filter($riwayat, fn($r) => $r['status_validasi'] === 'valid'));
$jumlahUnsigned = count(array_filter($riwayat, fn($r) => $r['status_validasi'] === 'unsigned'));
$jumlahReview = count(array_filter($riwayat, fn($r) => in_array($r['status_validasi'], ['review', 'invalid'])));
?>

<section class="follow-summary">
    <article class="follow-card">
        <div class="follow-card-label">Tanda Tangan Valid</div>
        <div class="follow-card-bottom">
            <strong class="text-green" id="countSigned"><?= $jumlahValid ?></strong>
            <span class="follow-icon green"><i class="bi bi-shield-check"></i></span>
        </div>
        <small>Dokumen dengan tanda tangan digital valid</small>
    </article>

    <article class="follow-card">
        <div class="follow-card-label">Tidak Ada Tanda Tangan</div>
        <div class="follow-card-bottom">
            <strong class="text-red" id="countUnsigned"><?= $jumlahUnsigned ?></strong>
            <span class="follow-icon red"><i class="bi bi-file-earmark-x"></i></span>
        </div>
        <small>Dokumen tanpa tanda tangan digital</small>
    </article>

    <article class="follow-card">
        <div class="follow-card-label">Perlu Diperiksa</div>
        <div class="follow-card-bottom">
            <strong class="text-orange" id="countReview"><?= $jumlahReview ?></strong>
            <span class="follow-icon orange"><i class="bi bi-exclamation-circle"></i></span>
        </div>
        <small>Dokumen tidak dapat dipastikan validitasnya</small>
    </article>
</section>

<section class="panel check-panel">
    <div class="panel-heading">
        <div>
            <h2><i class="bi bi-shield-check"></i> Pemeriksaan Dokumen</h2>
            <p>Masukkan link OneDrive yang dapat diakses siapa saja melalui tautan untuk memeriksa tanda tangan digital.</p>
        </div>
    </div>

    <div class="check-body">
        <form id="formPemeriksaan">
            <?= csrf_field() ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="namaPegawai">Nama Pegawai</label>
                    <input type="text"
                           name="nama"
                           id="namaPegawai"
                           class="form-control"
                           placeholder="Masukkan nama pegawai"
                           required>
                </div>

                <div class="form-group">
                    <label for="jenisDokumen">Jenis Dokumen</label>
                    <select name="jenis"
                            id="jenisDokumen"
                            class="form-select"
                            required>
                        <option value="">Pilih jenis dokumen</option>
                        <option>SKP Tahunan – Penetapan</option>
                        <option>SKP Periodik</option>
                        <option>SKP Tahunan – Penilaian</option>
                        <option>SKP Tahunan – Dokumen Evaluasi</option>
                        <option>Laporan Pekerjaan Pimpinan</option>
                        <option>PAK (1 Set 3 Dokumen) Tahunan</option>
                        <option>PAK Lainnya</option>
                        <option>BPE SPT Pajak – Coretax (di Simpeg)</option>
                        <option>SKP Tahunan Penetapan (SKP, di Simpeg)</option>
                        <option>SKP Tahunan Penilaian (PPK, di Simpeg)</option>
                    </select>
                </div>

                <div class="form-group year-field">
                    <label for="tahunDokumen">Tahun</label>
                    <select name="tahun"
                            id="tahunDokumen"
                            class="form-select"
                            required>
                        <option value="">Pilih tahun</option>
                        <?php foreach (range(2023, 2029) as $th): ?>
                            <option value="<?= $th ?>" <?= $th == date('Y') ? 'selected' : '' ?>>
                                <?= $th ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group link-field">
                    <label for="linkDokumen">Link Dokumen OneDrive</label>
                    <input type="url"
                           name="link_dokumen"
                           id="linkDokumen"
                           class="form-control"
                           placeholder="Tempel link OneDrive dokumen PDF"
                           autocomplete="url"
                           required>
                    <small class="form-hint">
                        Gunakan link OneDrive dengan akses Anyone with the link. File harus berupa PDF dan maksimal 20 MB.
                    </small>
                </div>
            </div>

            <div class="form-actions">
                <button type="reset" class="btn-reset" id="btnReset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset
                </button>

                <button type="submit" class="btn-scan-document" id="btnPeriksa">
                    <i class="bi bi-shield-check"></i>
                    Periksa Tanda Tangan
                </button>
            </div>
        </form>

        <div id="loadingPemeriksaan" class="loading-box" hidden>
            <div class="spinner-border text-primary"></div>
            <strong>Sedang memeriksa tanda tangan digital...</strong>
            <small>Proses ini mungkin memerlukan beberapa saat.</small>
        </div>

        <div class="result-box" id="hasilPemeriksaan" hidden>
            <div class="result-heading">
                <h3>Hasil Pemeriksaan</h3>
                <span id="statusBadge"></span>
            </div>

            <div class="result-detail">
                <div>
                    <small>Nama Pegawai</small>
                    <strong id="hasilNama">-</strong>
                </div>

                <div>
                    <small>Jenis Dokumen</small>
                    <strong id="hasilJenis">-</strong>
                </div>

                <div>
                    <small>Tahun</small>
                    <strong id="hasilTahun">-</strong>
                </div>

                <div>
                    <small>Nama File</small>
                    <strong id="hasilFile">-</strong>
                </div>
            </div>

            <div class="validation-detail">
                <strong id="hasilJudul">Status validasi</strong>
                <p id="hasilPesan"></p>
                <small id="hasilSertifikat"></small>
            </div>
        </div>
    </div>
</section>

<section class="panel history-panel">
    <div class="panel-heading">
        <div>
            <h2><i class="bi bi-clock-history"></i> Riwayat Pemeriksaan</h2>
            <p>Daftar dokumen yang telah melalui proses pemeriksaan.</p>
        </div>
    </div>

    <div class="history-filter">
        <input type="search"
               id="searchHistory"
               class="form-control"
               placeholder="Cari nama pegawai atau jenis dokumen...">

        <select id="filterStatus" class="form-select">
            <option value="">Semua Status</option>
            <option value="valid">Tanda Tangan Valid</option>
            <option value="unsigned">Tidak Ada Tanda Tangan</option>
            <option value="invalid">Tanda Tangan Tidak Valid</option>
            <option value="review">Perlu Diperiksa</option>
        </select>
    </div>

    <div class="table-responsive">
        <table class="table monitoring-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pegawai</th>
                    <th>Jenis Dokumen</th>
                    <th>Tahun</th>
                    <th>Status Pemeriksaan</th>
                    <th>Dokumen</th>
                    <th>Tanggal</th>
                </tr>
            </thead>

            <tbody id="historyBody">
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="7" class="empty-history">
                            <i class="bi bi-folder2-open"></i>
                            <strong>Belum ada dokumen diperiksa</strong>
                            <span>Riwayat pemeriksaan akan muncul di sini.</span>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $i => $item): ?>
                        <?php
                        $statusLabels = [
                            'valid' => 'Tanda Tangan Valid',
                            'unsigned' => 'Tidak Ada Tanda Tangan',
                            'invalid' => 'Tanda Tangan Tidak Valid',
                            'review' => 'Perlu Diperiksa'
                        ];

                        $statusClass = $item['status_validasi'];
                        ?>

                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($item['nama_pegawai']) ?></td>
                            <td><?= esc($item['jenis_dokumen']) ?></td>
                            <td><?= esc($item['tahun']) ?></td>
                            <td>
                                <span class="history-status <?= esc($statusClass) ?>">
                                    <?= esc($statusLabels[$statusClass] ?? 'Perlu Diperiksa') ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($item['link_dokumen'])): ?>
                                    <a href="<?= esc($item['link_dokumen']) ?>"
                                       target="_blank"
                                       rel="noopener noreferrer">Lihat PDF</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= date('d-m-Y H:i', strtotime($item['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<footer class="page-footer">
    SIPEDOK — Sistem Informasi Pelaporan Dokumen Pegawai
</footer>

<style>
.follow-summary {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:14px;
    margin-bottom:22px;
}

.follow-card {
    background:#fff;
    border:1px solid #e1e8f0;
    border-radius:11px;
    padding:20px;
}

.follow-card-label {
    color:#64748b;
    font-size:12px;
}

.follow-card-bottom {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:10px 0 5px;
}

.follow-card-bottom strong {
    font-size:27px;
}

.follow-card small {
    color:#8994a3;
    font-size:11px;
}

.text-green {color:#219b76;}
.text-red {color:#df5962;}
.text-orange {color:#e49a36;}

.follow-icon {
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    font-size:17px;
}

.follow-icon.green {color:#219b76;background:#e2f5ed;}
.follow-icon.red {color:#df5962;background:#ffebed;}
.follow-icon.orange {color:#e49a36;background:#fff1df;}

.check-panel,.history-panel {margin-bottom:22px;}
.check-body {padding:22px;}

.form-grid {
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:19px;
}

.form-group {
    display:flex;
    flex-direction:column;
    gap:8px;
    min-width:0;
}

.form-group label {
    color:#344054;
    font-size:12px;
    font-weight:600;
}

.form-group .form-control,
.form-group .form-select,
.history-filter .form-control,
.history-filter .form-select {
    min-height:40px;
    border:1px solid #dce4ed;
    border-radius:7px;
    color:#344054;
    font-size:12px;
    box-shadow:none;
}

.form-group .form-control:focus,
.form-group .form-select:focus {
    border-color:#29949b;
    box-shadow:0 0 0 3px rgba(41,148,155,.1);
}

.year-field {grid-column:1;}
.year-field .form-select {width:145px;max-width:100%;}
.link-field {grid-column:2;}

.form-hint {
    color:#8994a3;
    font-size:11px;
}

.form-actions {
    display:flex;
    justify-content:flex-end;
    gap:9px;
    margin-top:22px;
}

.btn-reset,.btn-scan-document {
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    padding:10px 15px;
    border-radius:7px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
}

.btn-reset {
    color:#64748b;
    background:#fff;
    border:1px solid #dce4ed;
}

.btn-scan-document {
    color:#fff;
    background:#173d59;
    border:1px solid #173d59;
}

.btn-scan-document:hover {background:#245573;}
.btn-scan-document:disabled {opacity:.6;cursor:wait;}

.loading-box {
    padding:35px 15px;
    display:flex;
    align-items:center;
    flex-direction:column;
    gap:12px;
    color:#173d59;
    text-align:center;
}

.loading-box strong {font-size:13px;}
.loading-box small {color:#8994a3;font-size:11px;}

.result-box {
    margin-top:24px;
    padding:20px;
    border:1px solid #e1e8f0;
    border-radius:10px;
    background:#fff;
}

.result-heading {
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    padding-bottom:15px;
    border-bottom:1px solid #e9eef3;
}

.result-heading h3 {
    margin:0;
    color:#173d59;
    font-size:15px;
    font-weight:700;
}

.result-badge,.history-status {
    display:inline-flex;
    align-items:center;
    padding:7px 11px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
}

.result-badge.valid,.history-status.valid {
    color:#218566;
    background:#e3f5ed;
}

.result-badge.unsigned,.history-status.unsigned {
    color:#d64d58;
    background:#ffebed;
}

.result-badge.invalid,.history-status.invalid,
.result-badge.review,.history-status.review {
    color:#b77a1c;
    background:#fff2df;
}

.result-detail {
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:18px;
    padding:20px 0;
}

.result-detail div {
    display:flex;
    flex-direction:column;
    gap:5px;
}

.result-detail small {
    color:#8994a3;
    font-size:11px;
}

.result-detail strong {
    color:#344054;
    font-size:12px;
    overflow-wrap:anywhere;
}

.validation-detail {
    padding:15px;
    background:#f5f8fb;
    border-radius:8px;
}

.validation-detail strong {
    color:#173d59;
    font-size:13px;
}

.validation-detail p {
    margin:7px 0;
    color:#64748b;
    font-size:12px;
    overflow-wrap:anywhere;
}

.validation-detail small {
    color:#8994a3;
    font-size:11px;
    overflow-wrap:anywhere;
}

.history-filter {
    display:flex;
    gap:10px;
    padding:0 20px 17px;
}

.history-filter .form-control {max-width:420px;}
.history-filter .form-select {max-width:210px;}

.empty-history {
    text-align:center;
    padding:40px 10px!important;
}

.empty-history i {
    display:block;
    color:#a5b1bf;
    font-size:28px;
    margin-bottom:9px;
}

.empty-history strong,.empty-history span {display:block;}
.empty-history strong {color:#526274;font-size:12px;}
.empty-history span {color:#9aa5b3;font-size:11px;margin-top:5px;}

@media(max-width:768px) {
    .follow-summary {grid-template-columns:1fr;}
    .form-grid {grid-template-columns:1fr;}
    .year-field,.link-field {grid-column:1;}
    .year-field .form-select {width:100%;}
    .history-filter {flex-direction:column;}
    .history-filter .form-control,
    .history-filter .form-select {max-width:100%;}
}

@media(max-width:600px) {
    .result-detail {grid-template-columns:1fr;}
}
</style>

<script>
const formPemeriksaan = document.getElementById('formPemeriksaan');
const loadingPemeriksaan = document.getElementById('loadingPemeriksaan');
const hasilPemeriksaan = document.getElementById('hasilPemeriksaan');
const btnPeriksa = document.getElementById('btnPeriksa');

const csrfName = <?= json_encode(csrf_token()) ?>;
let csrfHash = <?= json_encode(csrf_hash()) ?>;

const statusLabels = {
    valid: 'Tanda Tangan Digital Valid',
    unsigned: 'Tidak Ada Tanda Tangan Digital',
    invalid: 'Tanda Tangan Digital Tidak Valid',
    review: 'Perlu Diperiksa'
};

// PROSES PEMERIKSAAN PDF
formPemeriksaan.addEventListener('submit', async function(e) {
    e.preventDefault();

    if (!formPemeriksaan.reportValidity()) return;

    const linkDokumen = document.getElementById('linkDokumen').value.trim();

    if (!linkDokumen) {
        alert('Masukkan link dokumen OneDrive terlebih dahulu.');
        return;
    }

    let parsedLink;
    try {
        parsedLink = new URL(linkDokumen);
    } catch (error) {
        alert('Format link OneDrive tidak valid.');
        return;
    }

    if (parsedLink.protocol !== 'https:') {
        alert('Link dokumen harus menggunakan HTTPS.');
        return;
    }

    const data = new FormData(formPemeriksaan);
    data.set(csrfName, csrfHash);

    hasilPemeriksaan.hidden = true;
    loadingPemeriksaan.hidden = false;
    btnPeriksa.disabled = true;

    try {
        const response = await fetch(
            "<?= site_url('tindak-lanjut/verifikasi') ?>",
            {
                method: 'POST',
                body: data,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            }
        );

        // Baca respons server sebagai teks.
        const responseText = await response.text();

        let result;

        // Pastikan respons merupakan JSON.
        try {
            result = JSON.parse(responseText);
        } catch (jsonError) {
            console.error('Respons server:', responseText);

            throw new Error(
                'Respons server bukan JSON.' +
                '\nHTTP Status: ' + response.status +
                '\n\nRespons server:\n' + responseText.substring(0, 2000)
            );
        }

        // Perbarui token CSRF.
        if (result.csrfHash) {
            csrfHash = result.csrfHash;
        }

        // Tampilkan detail apabila pemeriksaan gagal.
        if (!response.ok || !result.success) {
            let pesan = result.message || 'Pemeriksaan gagal.';

            pesan += '\n\nHTTP Status: ' + response.status;

            if (result.detail) {
                pesan += '\n\nDetail Error:\n' + result.detail;
            }

            if (result.exit_code !== undefined) {
                pesan += '\n\nExit Code: ' + result.exit_code;
            }

            if (result.python) {
                pesan += '\n\nPython: ' + result.python;
            }

            if (result.script) {
                pesan += '\n\nScript: ' + result.script;
            }

            if (result.pdf) {
                pesan += '\n\nFile PDF: ' + result.pdf;
            }

            if (result.lokasi_dicari) {
                pesan += '\n\nLokasi Script: ' + result.lokasi_dicari;
            }

            console.error('Detail kegagalan:', result);

            throw new Error(pesan);
        }

        // Tampilkan hasil pemeriksaan.
        tampilkanHasil(result);

        // Perbarui riwayat.
        await muatRiwayat();

    } catch (error) {
        console.error('Kesalahan pemeriksaan:', error);

        alert(
            error.message ||
            'Terjadi kesalahan saat memeriksa dokumen.'
        );

    } finally {
        loadingPemeriksaan.hidden = true;
        btnPeriksa.disabled = false;
    }
});


// MENAMPILKAN HASIL PEMERIKSAAN
function tampilkanHasil(result) {
    const status = result.status || 'review';

    const badge = document.getElementById('statusBadge');

    badge.className = 'result-badge ' + status;
    badge.textContent = statusLabels[status] || statusLabels.review;

    document.getElementById('hasilNama').textContent =
        document.getElementById('namaPegawai').value;

    document.getElementById('hasilJenis').textContent =
        document.getElementById('jenisDokumen').value;

    document.getElementById('hasilTahun').textContent =
        document.getElementById('tahunDokumen').value;

    document.getElementById('hasilFile').textContent =
        'Dokumen OneDrive.pdf';

    document.getElementById('hasilJudul').textContent =
        statusLabels[status] || statusLabels.review;

    document.getElementById('hasilPesan').textContent =
        result.message || 'Tidak ada keterangan tambahan.';

    document.getElementById('hasilSertifikat').textContent = '';
    document.getElementById('hasilSertifikat').hidden = true;

    hasilPemeriksaan.hidden = false;

    hasilPemeriksaan.scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });
}


// MEMUAT RIWAYAT PEMERIKSAAN
async function muatRiwayat() {
    try {
        const response = await fetch(
            "<?= site_url('tindak-lanjut/riwayat') ?>",
            {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            }
        );

        const result = await response.json();

        if (result.csrfHash) {
            csrfHash = result.csrfHash;
        }

        if (!response.ok || !result.success) {
            throw new Error('Gagal memuat riwayat pemeriksaan.');
        }

        renderHistory(result.data || []);

    } catch (error) {
        console.error('Gagal memuat riwayat:', error);
    }
}


// MENCEGAH HTML BERBAHAYA MASUK KE TABEL
function escapeHTML(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[char]);
}


// MENAMPILKAN TABEL RIWAYAT
function renderHistory(data) {
    const search = document.getElementById('searchHistory')
        .value.toLowerCase();

    const filter = document.getElementById('filterStatus').value;

    const filtered = data.filter(item => {
        const nama = String(item.nama_pegawai || '').toLowerCase();
        const jenis = String(item.jenis_dokumen || '').toLowerCase();

        const matchesSearch =
            nama.includes(search) || jenis.includes(search);

        const matchesStatus =
            !filter || item.status_validasi === filter;

        return matchesSearch && matchesStatus;
    });

    // Perbarui ringkasan.
    document.getElementById('countSigned').textContent =
        data.filter(x => x.status_validasi === 'valid').length;

    document.getElementById('countUnsigned').textContent =
        data.filter(x => x.status_validasi === 'unsigned').length;

    document.getElementById('countReview').textContent =
        data.filter(x =>
            ['review', 'invalid'].includes(x.status_validasi)
        ).length;

    const tbody = document.getElementById('historyBody');

    if (!filtered.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="empty-history">
                    <i class="bi bi-folder2-open"></i>
                    <strong>Tidak ada riwayat pemeriksaan</strong>
                    <span>Dokumen yang telah diperiksa akan muncul di sini.</span>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = filtered.map((item, index) => {
        const status = item.status_validasi || 'review';
        const label = statusLabels[status] || statusLabels.review;

        return `
            <tr>
                <td>${index + 1}</td>
                <td>${escapeHTML(item.nama_pegawai)}</td>
                <td>${escapeHTML(item.jenis_dokumen)}</td>
                <td>${escapeHTML(item.tahun)}</td>
                <td>
                    <span class="history-status ${escapeHTML(status)}">
                        ${escapeHTML(label)}
                    </span>
                </td>
                <td>
                    ${String(item.link_dokumen || '').startsWith('https://')
                        ? `<a href="${escapeHTML(item.link_dokumen)}" target="_blank" rel="noopener noreferrer">Lihat PDF</a>`
                        : '-'}
                </td>
                <td>${escapeHTML(item.created_at)}</td>
            </tr>
        `;
    }).join('');
}


// PENCARIAN RIWAYAT
document.getElementById('searchHistory')
    .addEventListener('input', muatRiwayat);


// FILTER STATUS
document.getElementById('filterStatus')
    .addEventListener('change', muatRiwayat);


// TOMBOL RESET
document.getElementById('btnReset')
    .addEventListener('click', function() {
        hasilPemeriksaan.hidden = true;
    });

</script>

<?= $this->include('layouts/footer') ?>
