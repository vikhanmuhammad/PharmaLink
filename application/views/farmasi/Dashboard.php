<?php $this->load->view('header', ['title' => 'Dashboard Farmasi']); ?>

<div class="container mt-4">

    <h1 class="display-5">Selamat datang, <span class="text-success"><?= $this->session->userdata('username'); ?>!</span></h1>

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

    <div class="card my-4 border-success">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Menu Navigasi</h3>
        </div>
        <div class="card-body">
            <div class="list-group">
                <a href="<?= site_url('obat'); ?>" class="list-group-item list-group-item-action">
                    📦 Manajemen Stok Obat
                </a>
                <a href="<?= site_url('auth/logout'); ?>" class="list-group-item list-group-item-action list-group-item-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <h2 class="mt-5">Daftar Pemesanan Obat</h2>

    <div class="card mb-5">
        <div class="card-body p-0">
            <?php if(!empty($pemesanan)): ?>
                <div class="table-responsive">
                    <table id="pesananObat" class="table table-striped table-bordered table-hover mb-0">
                        <thead class="table-success">
                            <tr>
                                <th>ID</th>
                                <th>Pasien</th>
                                <th>Obat</th>
                                <th>Jumlah Pesan</th>
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
                                <td class="align-middle text-center"><?= $p->JUMLAH ?></td>
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
                                            $badge_class = 'bg-secondary';
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
                <div class="alert alert-info mb-0 text-center" role="alert">
                    Tidak ada pemesanan obat saat ini.
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {
    $('#pesananObat').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "order": [[0, "asc"]],
    });
});
</script>

<?php $this->load->view('footer'); ?>