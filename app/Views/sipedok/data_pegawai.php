
<?= $this->include('layouts/header') ?>

<style>
.employee-page { color:#172f53; }
.employee-page .subtitle { color:#718096; font-size:13px; }
.employee-panel,.employee-stat {
    background:#fff;
    border:1px solid #e0e7f0;
    border-radius:12px;
    padding:22px;
}
.employee-panel { margin-bottom:22px; }
.employee-stat { height:100%; }
.employee-stat .label { color:#64748b; font-size:13px; }
.employee-stat .number {
    font-size:29px;
    font-weight:700;
    margin-top:17px;
    color:#172f53;
}
.employee-filter {
    border:1px solid #dbe3ee;
    border-radius:8px;
    padding:10px 12px;
    background:#fff;
    width:100%;
    color:#172f53;
}
.employee-btn {
    background:#172f53;
    color:white;
    border:0;
    border-radius:8px;
    padding:11px 20px;
}
.employee-btn:hover { background:#284875; color:white; }
.employee-table th {
    background:#f4f7fb;
    color:#425675;
    font-size:12px;
    padding:14px;
    white-space:nowrap;
}
.employee-table td {
    padding:15px 14px;
    font-size:13px;
    color:#52627a;
    vertical-align:middle;
}
.employee-empty {
    padding:45px 15px !important;
    text-align:center;
    color:#94a3b8 !important;
}
</style>

<main class="employee-page">

    <header class="page-header">
        <div>
            <h1>Data Pegawai</h1>
            <p>Rekap jumlah pegawai berdasarkan tahun dan direktorat.</p>
        </div>

        <form action="<?= site_url('data-pegawai') ?>"
              method="get" class="filter-form">

            <div class="filter-field">
                <label for="tahun">Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    <?php foreach (range(2023, 2029) as $th): ?>
                        <option value="<?= $th ?>"
                            <?= (int)$tahun === $th ? 'selected' : '' ?>>
                            <?= $th ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn-apply">Terapkan</button>
        </form>
    </header>


    <section class="row g-3 mb-4">

        <div class="col-md-6">
            <article class="employee-stat">
                <div class="label">Total Pegawai</div>
                <div class="number">
                    <?= number_format((int)($totalPegawai ?? 0),0,',','.') ?>
                </div>
                <p class="subtitle mt-2 mb-0">
                    Jumlah pegawai tahun <?= esc($tahun) ?>
                </p>
            </article>
        </div>

        <div class="col-md-6">
            <article class="employee-stat">
                <div class="label">Jumlah Direktorat</div>
                <div class="number">
                    <?= count($daftarDirektorat ?? []) ?>
                </div>
                <p class="subtitle mt-2 mb-0">
                    Direktorat yang tercatat dalam rekap
                </p>
            </article>
        </div>

    </section>

    <section class="employee-panel">
        <div class="mb-4">
            <h2 class="h5 fw-bold">Rekap Pegawai per Direktorat</h2>
            <p class="subtitle mb-0">
                Jumlah pegawai berdasarkan tahun yang dipilih.
            </p>
        </div>

        <div class="table-responsive">
            <table class="table employee-table mb-0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tahun</th>
                        <th>Direktorat</th>
                        <th class="text-end">Jumlah Pegawai</th>
                        <th class="text-end">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($rekapPegawai)): ?>
                        <?php foreach ($rekapPegawai as $i => $row): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($row['tahun']) ?></td>
                                <td><?= esc($row['direktorat']) ?></td>
                                <td class="text-end">
                                    <?= number_format((int)$row['jumlah_pegawai'],0,',','.') ?>
                                </td>
                                <td class="text-end">
                                    <?= esc($row['persentase'] ?? 0) ?>%
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="employee-empty">
                                Belum ada data pegawai yang tersedia.
                                <p class="subtitle mt-2 mb-0">
                                    Data akan muncul setelah sumber data terhubung.
                                </p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

<footer class="page-footer">
    SIPEDOK — Sistem Informasi Pelaporan Dokumen Pegawai
</footer>

<?= $this->include('layouts/footer') ?>
