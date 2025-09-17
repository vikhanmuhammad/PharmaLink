<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Dokter</title>
</head>
<body>
    <h1>Selamat datang, Dokter <?= $this->session->userdata('username'); ?>!</h1>
    
    <p>Menu:</p>
    <ul>
        <li><a href="<?= site_url('dokter/pasien'); ?>">Manajemen Pasien</a></li>
        <li><a href="<?= site_url('dokter/pemesanan_obat'); ?>">Pemesanan Obat</a></li>
        <li><a href="<?= site_url('auth/logout'); ?>">Logout</a></li>
    </ul>

    <h2>Daftar Pemesanan Obat</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Pasien</th>
            <th>Obat</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Tanggal Pesan</th>
            <th>Status</th>
        </tr>
        <?php if (!empty($pemesanan)): ?>
            <?php foreach ($pemesanan as $row): ?>
            <tr>
                <td><?= $row->PEMESANAN_ID; ?></td>
                <td><?= $row->NAMA_PASIEN; ?></td>
                <td><?= $row->NAMA_OBAT; ?></td>
                <td><?= $row->JUMLAH; ?></td>
                <td><?= $row->KETERANGAN; ?></td>
                <td><?= $row->TGL_PESAN; ?></td>
                <td><?= ucfirst($row->STATUS); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Belum ada pemesanan obat.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
