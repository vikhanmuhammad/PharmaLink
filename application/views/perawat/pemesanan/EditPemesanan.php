<?php $this->load->view('header',['title'=>'Edit Pemesanan Obat']); ?>

<div class="container mt-4">
    <h2>Edit Pemesanan Obat #<?= $pemesanan->PEMESANAN_ID; ?></h2>

    <form method="post" action="<?= site_url('perawat/update_pemesanan/'.$pemesanan->PEMESANAN_ID); ?>">
        <div class="mb-3">
            <label for="pasien_id" class="form-label">Pasien</label>
            <select class="form-select" name="pasien_id" required>
                <?php foreach($pasien as $p): ?>
                    <option value="<?= $p->PASIEN_ID; ?>" <?= $p->PASIEN_ID==$pemesanan->PASIEN_ID?'selected':'' ?>>
                        <?= $p->NAMA; ?> (<?= $p->TGL_LAHIR; ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="obatList">
            <?php foreach($pemesanan->detail as $i => $d): ?>
            <div class="row mb-3 obat-item">
                <div class="col-md-5">
                    <select class="form-select" name="obat_id[]" required>
                        <?php foreach($obat as $o): ?>
                            <option value="<?= $o->OBAT_ID; ?>" <?= $o->OBAT_ID==$d->OBAT_ID?'selected':'' ?>>
                                <?= $o->NAMA_OBAT; ?> (Stok: <?= $o->STOK; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="jumlah[]" min="1" value="<?= $d->JUMLAH; ?>" required>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="keterangan[]" value="<?= $d->KETERANGAN; ?>" placeholder="Keterangan / Aturan Pakai">
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <button type="button" id="addObatRow" class="btn btn-secondary btn-sm mb-3">Tambah Obat</button>
        <br>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="<?= site_url('perawat'); ?>" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
$('#addObatRow').click(function(){
    var row = $('.obat-item:first').clone();
    row.find('input, select').val('');
    $('#obatList').append(row);
});
</script>

<?php $this->load->view('footer'); ?>
