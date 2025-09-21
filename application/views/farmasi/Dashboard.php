<?php $this->load->view('header', ['title' => 'Dashboard']); ?>

<div class="container mt-4">

    <h1 class="display-5">Selamat datang, <small class="text-muted"><?= $this->session->userdata('USERNAME'); ?>!</small></h1>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card my-4">
        <div class="card-header">
            <h3>Menu</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">📦 <a href="<?= site_url('obat'); ?>" class="text-decoration-none">Lihat Stok Obat</a></li>
            </ul>
        </div>
    </div>

    <h2 class="mt-5">Pemesanan Obat</h2>

    <?php if(!empty($pemesanan)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Pasien</th>
                        <th>Obat</th>
                        <th>Stok</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Tanggal Pesan</th>
                        <th>Penginput</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pemesanan as $p): ?>
                    <tr>
                        <td class="align-middle"><?= $p->PEMESANAN_ID ?></td>
                        <td class="align-middle"><?= $p->NAMA_PASIEN ?></td>
                        <td class="align-middle"><?= $p->NAMA_OBAT ?></td>
                        <td class="align-middle"><?= $p->STOK_OBAT ?></td>
                        <td class="align-middle"><?= $p->JUMLAH ?></td>
                        <td class="align-middle"><?= $p->KETERANGAN ?></td>
                        <td class="align-middle"><?= $p->TGL_PESAN ?></td>
                        <td class="align-middle"><?= $p->NAMA_PENGINPUT ?></td>
                        <td class="align-middle"><?= $p->ROLE_PENGINPUT ?></td>
                        <td class="text-center">
                            <?php if($p->STATUS == 'pending'): ?>
                                <div class="btn-group" role="group">
                                    <a href="<?= site_url('farmasi/approve/'.$p->PEMESANAN_ID) ?>" class="btn btn-sm btn-success">ACC</a>
                                    <a href="<?= site_url('farmasi/reject/'.$p->PEMESANAN_ID) ?>" class="btn btn-sm btn-danger">Reject</a>
                                </div>
                            <?php else: ?>
                                <?php
                                    // Ganti status teks menjadi badge berwarna
                                    $badge_class = 'bg-secondary'; // default
                                    if ($p->STATUS == 'approved') $badge_class = 'bg-success';
                                    if ($p->STATUS == 'rejected') $badge_class = 'bg-danger';
                                ?>
                                <span class="badge <?= $badge_class ?>"><?= ucfirst($p->STATUS) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info mt-3" role="alert">
            Tidak ada pemesanan obat saat ini.
        </div>
    <?php endif; ?>

    <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-secondary mt-4 mb-5">Logout</a>

</div>

<?php $this->load->view('footer'); ?> 