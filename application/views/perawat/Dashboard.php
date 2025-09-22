<?php $this->load->view('header', ['title' => 'Dashboard']); ?>

<div class="container mt-4">
    <h1 class="display-5">Selamat datang, <span class="text-success">Perawat <?= $this->session->userdata('username'); ?>!</span></h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card my-4 border-success">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Menu Navigasi</h3>
        </div>
        <div class="card-body">
            <div class="list-group">
                <a href="<?= site_url('perawat/pasien'); ?>" class="list-group-item list-group-item-action">
                    <i class="fas fa-users"></i> Manajemen Pasien
                </a>
                <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#pemesananObatModal">
                    <i class="fas fa-pills"></i> Buat Pemesanan Obat Baru
                </button>
                <a href="<?= site_url('auth/logout'); ?>" class="list-group-item list-group-item-action list-group-item-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="h5 mb-0 mt-1">Daftar Pemesanan Obat Terakhir</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover mb-0">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Pasien</th>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Tanggal Pesan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pemesanan)): ?>
                            <?php foreach ($pemesanan as $row): ?>
                            <tr>
                                <td class="align-middle"><?= $row->PEMESANAN_ID; ?></td>
                                <td class="align-middle"><?= $row->NAMA_PASIEN; ?></td>
                                <td class="align-middle"><?= $row->NAMA_OBAT; ?></td>
                                <td class="align-middle"><?= $row->JUMLAH; ?></td>
                                <td class="align-middle"><?= $row->KETERANGAN; ?></td>
                                <td class="align-middle"><?= $row->TGL_PESAN; ?></td>
                                <td class="text-center align-middle">
                                    <?php
                                        $badge_class = 'bg-secondary';
                                        if ($row->STATUS == 'approved') $badge_class = 'bg-success';
                                        if ($row->STATUS == 'rejected') $badge_class = 'bg-danger';
                                        if ($row->STATUS == 'pending') $badge_class = 'bg-warning text-dark';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= ucfirst($row->STATUS); ?></span>
                                </td>
                                <td class="text-center align-middle">
                                    <?php if ($row->STATUS == 'pending'): ?>
                                        <a href="<?= site_url('perawat/edit_pemesanan/'.$row->PEMESANAN_ID); ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted p-4">
                                    <em>Belum ada data pemesanan obat.</em>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pemesananObatModal" tabindex="-1" aria-labelledby="pemesananObatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= site_url('perawat/pemesanan_obat'); ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="pemesananObatModalLabel">Formulir Pemesanan Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pasien_id" class="form-label">Pilih Pasien</label>
                        <select class="form-select" id="pasien_id" name="pasien_id" required>
                            <option value="" selected disabled>-- Daftar Pasien Anda --</option>
                            <?php foreach ($pasien as $p): ?>
                                <option value="<?= $p->PASIEN_ID; ?>"><?= $p->NAMA; ?> (Lahir: <?= $p->TGL_LAHIR; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="obat_id" class="form-label">Pilih Obat</label>
                        <select class="form-select" id="obat_id" name="obat_id" required>
                            <option value="" selected disabled>-- Daftar Obat Tersedia --</option>
                            <?php foreach ($obat as $o): ?>
                                <option value="<?= $o->OBAT_ID; ?>"><?= $o->NAMA_OBAT; ?> (Stok: <?= $o->STOK; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan / Aturan Pakai</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Buat Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $this->load->view('footer'); ?>