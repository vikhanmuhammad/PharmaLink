<?php $this->load->view('header', ['title' => 'Tambah Pasien']); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Cari atau Tambah Pasien</h2>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">
                        Masukkan nama dan tanggal lahir untuk memeriksa apakah pasien sudah ada di database.
                    </p>
                    
                    <form method="post">
                        <input type="hidden" name="action" value="cari">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= isset($nama) ? $nama : '' ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?= isset($tgl_lahir) ? $tgl_lahir : '' ?>" required>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('dokter/pasien'); ?>" class="btn btn-outline-secondary">Kembali ke Daftar Pasien</a>
                            <button type="submit" class="btn btn-primary">Cari Pasien</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (isset($pasien)) : ?>
            <div class="card mt-4">
                <div class="card-header">
                    <h4 class="h5 mb-0">Hasil Pencarian</h4>
                </div>
                <div class="card-body">
                    <?php if ($pasien) : ?>

                        <?php if ($pasien->ASSIGNED_DOKTER_ID) : ?>
                            <div class="alert alert-success mb-0">
                                ✅ Pasien <strong><?= $pasien->NAMA ?> (<?= $pasien->TGL_LAHIR ?>)</strong> ditemukan dan sudah terdaftar pada profil Anda.
                            </div>
                        <?php else : ?>
                            <div class="alert alert-info d-flex justify-content-between align-items-center mb-0">
                                <span>Pasien <strong><?= $pasien->NAMA ?> (<?= $pasien->TGL_LAHIR ?>)</strong> ditemukan.</span>
                                <form method="post" class="ms-3">
                                    <input type="hidden" name="action" value="assign">
                                    <input type="hidden" name="pasien_id" value="<?= $pasien->PASIEN_ID ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Assign ke Profil Saya</button>
                                </form>
                            </div>
                        <?php endif; ?>

                    <?php else : ?>
                        <div class="alert alert-warning d-flex justify-content-between align-items-center mb-0">
                            <span>Pasien tidak ditemukan. Tambahkan sebagai data baru?</span>
                            <form method="post" class="ms-3">
                                <input type="hidden" name="action" value="tambah">
                                <input type="hidden" name="nama" value="<?= isset($nama) ? $nama : '' ?>">
                                <input type="hidden" name="tgl_lahir" value="<?= isset($tgl_lahir) ? $tgl_lahir : '' ?>">
                                <button type="submit" class="btn btn-sm btn-primary">Ya, Tambah Pasien</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>