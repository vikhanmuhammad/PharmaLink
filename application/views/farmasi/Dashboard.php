<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Farmasi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2F4F4F; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #ddd; }
        button { padding: 5px 10px; border: none; border-radius: 5px; background-color: #1E90FF; color: #fff; cursor: pointer; }
        button.reject { background-color: #FF4500; }
        button:hover { opacity: 0.8; }
        .flash { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Selamat datang, <?= $this->session->userdata('USERNAME'); ?>!</h1>

    <?php if($this->session->flashdata('success')): ?>
        <div class="flash success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="flash error"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <div class="menu-box">
        <h3>Menu:</h3>
        <ul>
            <li>📦 <a href="<?= site_url('obat'); ?>">Lihat Stok Obat</a></li>
        </ul>
    </div>

    <h2>Pemesanan Obat</h2>

    <?php if(!empty($pemesanan)): ?>
        <table>
            <thead>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($pemesanan as $p): ?>
                <tr>
                    <td><?= $p->PEMESANAN_ID ?></td>
                    <td><?= $p->NAMA_PASIEN ?></td>
                    <td><?= $p->NAMA_OBAT ?></td>
                    <td><?= $p->STOK_OBAT ?></td>
                    <td><?= $p->JUMLAH ?></td>
                    <td><?= $p->KETERANGAN ?></td>
                    <td><?= $p->TGL_PESAN ?></td>
                    <td><?= $p->NAMA_PENGINPUT ?></td>
                    <td><?= $p->ROLE_PENGINPUT ?></td>
                    <td>
                        <?php if($p->STATUS == 'pending'): ?>
                            <a href="<?= site_url('farmasi/approve/'.$p->PEMESANAN_ID) ?>">
                                <button>ACC</button>
                            </a>
                            <a href="<?= site_url('farmasi/reject/'.$p->PEMESANAN_ID) ?>">
                                <button class="reject">Reject</button>
                            </a>
                        <?php else: ?>
                            <?= ucfirst($p->STATUS) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada pemesanan obat.</p>
    <?php endif; ?>

    <br><a href="<?= site_url('auth/logout'); ?>">Logout</a>
</body>
</html>
