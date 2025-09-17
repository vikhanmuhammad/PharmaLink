<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pasien</title>
</head>
<body>
    <h2>Daftar Pasien Anda</h2>
    <a href="<?= site_url('dokter/tambah_pasien'); ?>">Tambah Pasien Baru</a> |
    <a href="<?= site_url('dokter'); ?>">Dashboard</a>
    <br><br>

    <?php if (empty($pasien)): ?>
        <p>Data pasien kosong.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
            </tr>
            <?php foreach ($pasien as $p): ?>
            <tr>
                <td><?= $p->PASIEN_ID; ?></td>
                <td><?= $p->NAMA; ?></td>
                <td><?= $p->TGL_LAHIR; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
