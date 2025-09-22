<?php $this->load->view('header', ['title' => 'Dashboard']); ?>

<div class="container mt-4">

    <h1 class="display-5">Selamat datang, <span class="text-success">Dokter <?= $this->session->userdata('username'); ?>!</span></h1>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card my-4 border-success">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Menu Navigasi</h3>
        </div>
        <div class="card-body">
            <div class="list-group">
                <a href="<?= site_url('dokter/pasien'); ?>" class="list-group-item list-group-item-action">
                    <i class="fas fa-users"></i> Manajemen Pasien
                </a>
                <button type="button" class="list-group-item list-group-item-action" data-bs-toggle="modal" data-bs-target="#pemesananObatModal">
                    Buat Pemesanan Obat Baru
                </button>
                <a href="<?= site_url('auth/logout'); ?>" class="list-group-item list-group-item-action list-group-item-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="h5 mb-0 mt-1">Daftar Pemesanan Obat Terakhir</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="obatDokter" class="table table-striped table-bordered table-hover mb-0">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Pasien</th>
                            <th>Obat</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Tanggal Pesan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pemesanan)): ?>
                            <?php
                            $pesanan_grouped = [];
                            foreach($pemesanan as $row){
                                $pesanan_grouped[$row->PEMESANAN_ID]['info'] = [
                                    'NAMA_PASIEN' => $row->NAMA_PASIEN,
                                    'TGL_PESAN'   => $row->TGL_PESAN,
                                    'STATUS'      => $row->STATUS,
                                ];
                                $pesanan_grouped[$row->PEMESANAN_ID]['obat'][] = [
                                    'NAMA_OBAT'   => $row->NAMA_OBAT,
                                    'JUMLAH'      => $row->JUMLAH,
                                    'KETERANGAN'  => $row->KETERANGAN
                                ];
                            }
                            ?>

                            <?php foreach($pesanan_grouped as $id => $data): ?>
                                <tr>
                                    <td class="align-middle"><?= $id; ?></td>
                                    <td class="align-middle"><?= $data['info']['NAMA_PASIEN']; ?></td>
                                    <td class="align-middle">
                                        <?php
                                        $obat_list = array_map(function($o){ return $o['NAMA_OBAT']; }, $data['obat']);
                                        echo implode(', ', $obat_list);
                                        ?>
                                    </td>
                                    <td class="align-middle text-center">
                                        <?php
                                        $jumlah_list = array_map(function($o){ return $o['JUMLAH']; }, $data['obat']);
                                        echo implode(', ', $jumlah_list);
                                        ?>
                                    </td>
                                    <td class="align-middle">
                                        <?php
                                        $ket_list = array_map(function($o){ return $o['KETERANGAN']; }, $data['obat']);
                                        echo implode('; ', $ket_list);
                                        ?>
                                    </td>
                                    <td class="align-middle"><?= $data['info']['TGL_PESAN']; ?></td>
                                    <td class="text-center align-middle">
                                        <?php
                                            $badge_class = 'bg-secondary';
                                            if ($data['info']['STATUS'] == 'approved') $badge_class = 'bg-success';
                                            if ($data['info']['STATUS'] == 'rejected') $badge_class = 'bg-danger';
                                            if ($data['info']['STATUS'] == 'pending') $badge_class = 'bg-warning text-dark';
                                        ?>
                                        <span class="badge <?= $badge_class ?>"><?= ucfirst($data['info']['STATUS']); ?></span>
                                    </td>
                                    <td class="text-center align-middle">
                                        <?php if ($data['info']['STATUS'] == 'pending'): ?>
                                            <a href="<?= site_url('dokter/edit_pemesanan/'.$id); ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted p-4">
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

<div class="modal fade" id="pemesananObatModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="<?= site_url('dokter/pemesanan_obat'); ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Formulir Pemesanan Obat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="pasien_id">Pilih Pasien</label>
                        <select class="form-select" id="pasien_id" name="pasien_id" required>
                            <option value="" disabled selected>-- Daftar Pasien --</option>
                            <?php foreach($pasien as $p): ?>
                                <option value="<?= $p->PASIEN_ID; ?>"><?= $p->NAMA; ?> (<?= $p->TGL_LAHIR; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <hr>
                    <div id="obatList">
                        <div class="row mb-3 obat-item">
                            <div class="col-md-5">
                                <select class="form-select" name="obat_id[]" required>
                                    <option value="" selected disabled>-- Pilih Obat --</option>
                                    <?php foreach($obat as $o): ?>
                                        <option value="<?= $o->OBAT_ID; ?>"><?= $o->NAMA_OBAT; ?> (Stok: <?= $o->STOK; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="jumlah[]" min="1" value="1" required>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="keterangan[]" placeholder="Keterangan / Aturan Pakai">
                            </div>
                        </div>
                    </div>
                    <button type="button" id="addObatRow" class="btn btn-secondary btn-sm">Tambah Obat</button>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Buat Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#addObatRow').click(function(){
    var row = $('.obat-item:first').clone();
    row.find('input, select').val('');
    $('#obatList').append(row);
});

</script>

<?php $this->load->view('footer'); ?>