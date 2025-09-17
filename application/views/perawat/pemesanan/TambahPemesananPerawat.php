<!DOCTYPE html>
<html>
<head>
    <title>Pemesanan Obat</title>
</head>
<body>
    <h2>Form Pemesanan Obat</h2>

    <?php if ($this->session->flashdata('success')): ?>
        <p style="color: green;"><?= $this->session->flashdata('success'); ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Pasien:</label><br>
        <select name="pasien_id" required>
            <option value="">-- Pilih Pasien --</option>
            <?php foreach ($pasien as $p): ?>
                <option value="<?= $p->PASIEN_ID; ?>"><?= $p->NAMA; ?> (<?= $p->TGL_LAHIR; ?>)</option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>Obat:</label><br>
        <select name="obat_id" required>
            <option value="">-- Pilih Obat --</option>
            <?php foreach ($obat as $o): ?>
                <option value="<?= $o->OBAT_ID; ?>"><?= $o->NAMA_OBAT; ?> (Stok: <?= $o->STOK; ?>)</option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label>Jumlah:</label><br>
        <input type="number" name="jumlah" min="1" required><br><br>

        <label>Keterangan:</label><br>
        <textarea name="keterangan"></textarea><br><br>

        <button type="submit">Pesan Obat</button>
    </form>

    <br>
    <a href="<?= site_url('perawat/'); ?>">Kembali</a>
</body>
</html>
