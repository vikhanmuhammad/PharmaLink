<?php $this->load->view('header', ['title' => 'Pemesanan Obat']); ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Formulir Pemesanan Obat</h2>
                </div>
                <div class="card-body">

                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('perawat/pemesanan_obat'); ?>">
                        <div class="mb-3">
                            <label for="pasien_id" class="form-label">Pilih Pasien</label>
                            <select class="form-select" id="pasien_id" name="pasien_id" required>
                                <option value="" selected disabled>-- Daftar Pasien Anda --</option>
                                <?php foreach ($pasien as $p): ?>
                                    <option value="<?= $p->PASIEN_ID; ?>"><?= $p->NAMA; ?> (Lahir: <?= $p->TGL_LAHIR; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="obat_id" class="form-label">Pilih Obat</label>
                            <select class="form-select" id="obat_id" name="obat_id" required>
                                <option value="" selected disabled>-- Daftar Obat Tersedia --</option>
                                <?php foreach ($obat as $o): ?>
                                    <option value="<?= $o->OBAT_ID; ?>"><?= $o->NAMA_OBAT; ?> (Stok: <?= $o->STOK; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan / Aturan Pakai</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('perawat/'); ?>" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
                            <button type="submit" class="btn btn-primary">Buat Pesanan Obat</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>