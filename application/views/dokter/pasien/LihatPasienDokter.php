<?php $this->load->view('header', ['title' => 'Daftar Pasien']); ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="display-6">Daftar Pasien Anda</h2>
        <div>
            <a href="<?= site_url('dokter/tambah_pasien'); ?>" class="btn btn-success">
                + Tambah Pasien Baru
            </a>
            <a href="<?= site_url('dokter'); ?>" class="btn btn-outline-secondary">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if (empty($pasien)): ?>
                <div class="alert alert-info mb-0" role="alert">
                    Anda belum memiliki data pasien. Silakan tambahkan pasien baru.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover mb-0">
                        <thead class="table-success">
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pasien as $p): ?>
                            <tr>
                                <td class="align-middle"><?= $p->PASIEN_ID; ?></td>
                                <td class="align-middle"><?= $p->NAMA; ?></td>
                                <td class="align-middle"><?= $p->TGL_LAHIR; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php $this->load->view('footer'); ?>