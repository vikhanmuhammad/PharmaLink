<?php $this->load->view('header', ['title' => 'Edit Pemesanan Obat']); ?>

<div class="container mt-4">
    <h2>Edit Pemesanan Obat #<?= $pemesanan->PEMESANAN_ID; ?></h2>

    <form method="post" action="<?= site_url('perawat/update_pemesanan/'.$pemesanan->PEMESANAN_ID); ?>">
        <div class="mb-3">
            <label for="pasien_id" class="form-label">Pasien</label>
            <select class="form-select" id="pasien_id" name="pasien_id" required>
                <?php foreach ($pasien as $p): ?>
                    <option value="<?= $p->PASIEN_ID; ?>" <?= $p->PASIEN_ID == $pemesanan->PASIEN_ID ? 'selected' : ''; ?>>
                        <?= $p->NAMA; ?> (<?= $p->TGL_LAHIR; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="obat_id" class="form-label">Obat</label>
            <select class="form-select" id="obat_id" name="obat_id" required>
                <?php foreach ($obat as $o): ?>
                    <option value="<?= $o->OBAT_ID; ?>" <?= $o->OBAT_ID == $pemesanan->OBAT_ID ? 'selected' : ''; ?>>
                        <?= $o->NAMA_OBAT; ?> (Stok: <?= $o->STOK; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="<?= $pemesanan->JUMLAH; ?>" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan / Aturan Pakai</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?= $pemesanan->KETERANGAN; ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="<?= site_url('perawat'); ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php $this->load->view('footer'); ?>
