<?php $this->load->view('header', ['title' => 'Dashboard']); ?>

<div class="container mt-4">

    <h1 class="display-5">Selamat datang, <span class="text-primary">Perawat <?= $this->session->userdata('username'); ?>!</span></h1>
    <p class="lead">Ini adalah halaman dashboard Anda.</p>

    <div class="card my-4 border-primary">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Menu Navigasi</h3>
        </div>
        <div class="card-body">
            <div class="list-group">
                <a href="<?= site_url('perawat/pasien'); ?>" class="list-group-item list-group-item-action">
                    <i class="fas fa-users"></i> Manajemen Pasien
                </a>
                <a href="<?= site_url('perawat/pemesanan_obat'); ?>" class="list-group-item list-group-item-action">
                    <i class="fas fa-pills"></i> Pemesanan Obat
                </a>
                <a href="<?= site_url('auth/logout'); ?>" class="list-group-item list-group-item-action list-group-item-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <h2 class="mt-5">Daftar Pemesanan Obat Terakhir</h2>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Pasien</th>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Tanggal Pesan</th>
                            <th class="text-center">Status</th>
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
                                        // Ganti status teks menjadi badge berwarna
                                        $badge_class = 'bg-secondary'; // default untuk status lain
                                        if ($row->STATUS == 'approved') $badge_class = 'bg-success';
                                        if ($row->STATUS == 'rejected') $badge_class = 'bg-danger';
                                        if ($row->STATUS == 'pending') $badge_class = 'bg-warning text-dark';
                                    ?>
                                    <span class="badge <?= $badge_class ?>"><?= ucfirst($row->STATUS); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted">
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

<script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

<?php $this->load->view('footer'); ?>