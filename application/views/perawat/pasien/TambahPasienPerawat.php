<!DOCTYPE html>
<html>
<head>
    <title>Tambah / Cari Pasien</title>
</head>
<body>
    <h2>Cari atau Tambah Pasien</h2>

    <form method="post">
        <input type="hidden" name="action" value="cari">
        <label>Nama Pasien:</label><br>
        <input type="text" name="nama" value="<?= isset($nama) ? $nama : '' ?>" required><br><br>

        <label>Tanggal Lahir:</label><br>
        <input type="date" name="tgl_lahir" value="<?= isset($tgl_lahir) ? $tgl_lahir : '' ?>" required><br><br>

        <button type="submit">Cari</button>
    </form>

    <br>

    <?php if (isset($pasien)) : ?>
        <?php if ($pasien) : ?>

            <?php if ($pasien->ASSIGNED_PERAWAT_ID) : ?>
                <p style="color: green;">
                    ✅ Pasien terdapat di database: <strong><?= $pasien->NAMA ?> (<?= $pasien->TGL_LAHIR ?>)</strong> dan sudah di-assign ke profil Anda.
                </p>
            <?php else : ?>
                <p>Pasien terdapat di database: <strong><?= $pasien->NAMA ?> (<?= $pasien->TGL_LAHIR ?>)</strong></p>
                <form method="post">
                    <input type="hidden" name="action" value="assign">
                    <input type="hidden" name="pasien_id" value="<?= $pasien->PASIEN_ID ?>">
                    <button type="submit">Assign ke Perawat</button>
                </form>
            <?php endif; ?>

        <?php else : ?>
            <p>Pasien tidak ditemukan di database. Tambahkan data baru?</p>
            <form method="post">
                <input type="hidden" name="action" value="tambah">
                <input type="hidden" name="nama" value="<?= isset($nama) ? $nama : '' ?>">
                <input type="hidden" name="tgl_lahir" value="<?= isset($tgl_lahir) ? $tgl_lahir : '' ?>">
                <button type="submit">Tambah Pasien Baru</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

    <br>
    <a href="<?= site_url('perawat/pasien'); ?>">Kembali</a>
</body>
</html>