
<?= $this->include('layouts/header') ?>

<!-- HEADER DASHBOARD -->
<header class="page-header">
    <div>
        <h1>Dashboard</h1>
        <p>Pantau kemajuan pelaporan dokumen pegawai dalam satu halaman.</p>
    </div>

    <form action="<?= site_url('dashboard') ?>" method="get" class="filter-form">

        <!-- FILTER TAHUN -->
        <div class="filter-field">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun" class="form-select">
                <?php foreach (range(2023, 2029) as $th): ?>
                    <option value="<?= $th ?>"
                        <?= (int) ($tahun ?? date('Y')) === $th ? 'selected' : '' ?>>
                        <?= $th ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- FILTER PERIODE -->
        <div class="filter-field">
            <label for="periode">Periode</label>
            <select name="periode" id="periode" class="form-select">
                <option value="semua"
                    <?= ($periode ?? 'semua') === 'semua' ? 'selected' : '' ?>>
                    Semua Periode
                </option>
                <option value="triwulan1"
                    <?= ($periode ?? '') === 'triwulan1' ? 'selected' : '' ?>>
                    Triwulan I
                </option>
                <option value="triwulan2"
                    <?= ($periode ?? '') === 'triwulan2' ? 'selected' : '' ?>>
                    Triwulan II
                </option>
                <option value="triwulan3"
                    <?= ($periode ?? '') === 'triwulan3' ? 'selected' : '' ?>>
                    Triwulan III
                </option>
                <option value="triwulan4"
                    <?= ($periode ?? '') === 'triwulan4' ? 'selected' : '' ?>>
                    Triwulan IV
                </option>
            </select>
        </div>

        <!-- FILTER JENIS DOKUMEN -->
        <div class="filter-field">
            <label for="jenis_dokumen">Jenis Dokumen</label>
            <select name="jenis_dokumen" id="jenis_dokumen" class="form-select">
                <option value="semua"
                    <?= ($jenis_dokumen ?? 'semua') === 'semua' ? 'selected' : '' ?>>
                    Semua Jenis Dokumen
                </option>
                <option value="A"
                    <?= ($jenis_dokumen ?? '') === 'A' ? 'selected' : '' ?>>
                    A - SKP Tahunan – Penetapan
                </option>
                <option value="B"
                    <?= ($jenis_dokumen ?? '') === 'B' ? 'selected' : '' ?>>
                    B - SKP Periodik
                </option>
                <option value="C"
                    <?= ($jenis_dokumen ?? '') === 'C' ? 'selected' : '' ?>>
                    C - SKP Tahunan – Penilaian
                </option>
                <option value="D"
                    <?= ($jenis_dokumen ?? '') === 'D' ? 'selected' : '' ?>>
                    D - SKP Tahunan – Dokumen Evaluasi
                </option>
                <option value="E"
                    <?= ($jenis_dokumen ?? '') === 'E' ? 'selected' : '' ?>>
                    E - Laporan Pekerjaan Pimpinan
                </option>
                <option value="F"
                    <?= ($jenis_dokumen ?? '') === 'F' ? 'selected' : '' ?>>
                    F - PAK (1 Set 3 Dokumen) Tahunan
                </option>
                <option value="G"
                    <?= ($jenis_dokumen ?? '') === 'G' ? 'selected' : '' ?>>
                    G - PAK Lainnya
                </option>
                <option value="H"
                    <?= ($jenis_dokumen ?? '') === 'H' ? 'selected' : '' ?>>
                    H - BPE SPT Pajak – Coretax (di Simpeg)
                </option>
                <option value="I"
                    <?= ($jenis_dokumen ?? '') === 'I' ? 'selected' : '' ?>>
                    I - SKP Tahunan Penetapan (SKP, di Simpeg)
                </option>
                <option value="J"
                    <?= ($jenis_dokumen ?? '') === 'J' ? 'selected' : '' ?>>
                    J - SKP Tahunan Penilaian (PPK, di Simpeg)
                </option>
            </select>
        </div>

        <button type="submit" class="btn-apply">Terapkan</button>
    </form>
</header>

<!-- KARTU RINGKASAN -->
<section class="summary-grid">

    <article class="summary-card">
        <div class="summary-top">
            <span>Total Pegawai</span>
            <span class="summary-icon icon-blue">
                <i class="bi bi-person-fill"></i>
            </span>
        </div>

        <div class="summary-number"><?= $ringkasan['total'] ?></div>
        <p class="summary-note">Jumlah pegawai pada tahun terpilih</p>
    </article>

    <article class="summary-card">
        <div class="summary-top">
            <span>Sudah Melapor</span>
            <span class="summary-icon icon-green">
                <i class="bi bi-check-lg"></i>
            </span>
        </div>

        <div class="summary-number"><?= $ringkasan['sudah'] ?></div>
        <p class="summary-note">Pegawai yang sudah melaporkan dokumen</p>
    </article>

    <article class="summary-card">
        <div class="summary-top">
            <span>Belum Melapor</span>
            <span class="summary-icon icon-orange">
                <i class="bi bi-exclamation-lg"></i>
            </span>
        </div>

        <div class="summary-number"><?= $ringkasan['belum'] ?></div>
        <p class="summary-note">Pegawai yang belum melaporkan dokumen</p>
    </article>

    <article class="summary-card">
        <div class="summary-top">
            <span>Kemajuan Pelaporan</span>
            <span class="summary-icon icon-purple">
                <i class="bi bi-clock-history"></i>
            </span>
        </div>

        <div class="summary-number">
            <?= $ringkasan['persentase'] ?><small>%</small>
        </div>

        <div class="summary-progress">
            <div style="width: <?= $ringkasan['persentase'] ?>%"></div>
        </div>

        <p class="summary-note">
            Status: <strong>Belum ada data</strong>
        </p>
    </article>

</section>

<!-- GRAFIK DAN PROGRES DOKUMEN -->
<section class="dashboard-grid">

    <article class="panel">
        <div class="panel-heading">
            <div>
                <h2>Jumlah Pegawai per Tahun</h2>
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

    <article class="panel" id="monitoring-dokumen">
        <div class="panel-heading">
            <div>
                <h2>Kemajuan per Jenis Dokumen</h2>
                <p>Persentase pegawai yang sudah melapor.</p>
            </div>

            <a href="#daftar-dokumen" class="view-all">Lihat semua →</a>
        </div>

        <div class="document-list">
            <?php foreach ($dokumen as $item): ?>
                <div class="document-item">
                    <div class="document-heading">
                        <div class="document-title">
                            <span class="document-code">
                                <?= esc($item['kode']) ?>
                            </span>

                            <span><?= esc($item['nama']) ?></span>
                        </div>

                        <strong>0%</strong>
                    </div>

                    <div class="progress-track">
                        <div class="progress-bar-empty"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </article>

</section>

<!-- DAFTAR JENIS DOKUMEN -->
<section class="panel table-panel" id="daftar-dokumen">
    <div class="panel-heading">
        <div>
            <h2>Monitoring Dokumen</h2>
            <p>Daftar jenis dokumen yang akan dipantau.</p>
        </div>

        <span class="total-label">
            <?= count($dokumen) ?> jenis dokumen
        </span>
    </div>

    <div class="table-responsive">
        <table class="table monitoring-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Jenis Dokumen</th>
                    <th>Total Wajib Lapor</th>
                    <th>Sudah Melapor</th>
                    <th>Belum Melapor</th>
                    <th>Kemajuan</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($dokumen as $item): ?>
                    <tr>
                        <td>
                            <span class="document-code">
                                <?= esc($item['kode']) ?>
                            </span>
                        </td>

                        <td><?= esc($item['nama']) ?></td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>

                        <td>
                            <div class="table-progress">
                                <div class="progress-track">
                                    <div class="progress-bar-empty"></div>
                                </div>
                                <span>0%</span>
                            </div>
                        </td>

                        <td>
                            <span class="status-label">Belum ada data</span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<footer class="page-footer">
    SIPEDOK — Sistem Informasi Pelaporan Dokumen Pegawai
</footer>

<?= $this->include('layouts/footer') ?>
