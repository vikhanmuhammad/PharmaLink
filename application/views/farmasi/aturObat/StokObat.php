<?php $this->load->view('header', ['title' => 'Manajemen Stok Obat']); ?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="display-6">Manajemen Stok Obat</h2>
        <div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahObatModal">
                + Tambah Obat Baru
            </button>
            <a href="<?php echo site_url('farmasi'); ?>" class="btn btn-outline-secondary">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelObat" class="table table-striped table-bordered table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>ID</th>
                            <th>Nama Obat</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Generic</th>
                            <th>Keterangan</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($obat)): ?>
                            <?php foreach ($obat as $o): ?>
                            <tr>
                                <td class="align-middle"><?php echo $o->OBAT_ID; ?></td>
                                <td class="align-middle"><?php echo $o->NAMA_OBAT; ?></td>
                                <td class="align-middle"><?php echo $o->JENIS; ?></td>
                                <td class="align-middle"><?php echo $o->KATEGORI; ?></td>
                                <td class="align-middle"><?php echo $o->GENERIC; ?></td>
                                <td class="align-middle"><?php echo $o->KETERANGAN; ?></td>
                                <?php
                                    $stok_class = ($o->STOK < 10) ? 'text-danger fw-bold' : '';
                                ?>
                                <td class="align-middle text-center <?= $stok_class ?>">
                                    <?php echo $o->STOK; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-warning btn-edit" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editObatModal"
                                            data-id="<?php echo $o->OBAT_ID; ?>"
                                            data-nama="<?php echo htmlspecialchars($o->NAMA_OBAT); ?>"
                                            data-jenis="<?php echo htmlspecialchars($o->JENIS); ?>"
                                            data-kategori="<?php echo htmlspecialchars($o->KATEGORI); ?>"
                                            data-generic="<?php echo htmlspecialchars($o->GENERIC); ?>"
                                            data-keterangan="<?php echo htmlspecialchars($o->KETERANGAN); ?>"
                                            data-stok="<?php echo $o->STOK; ?>">
                                            Edit
                                        </button>
                                        <a href="<?php echo site_url('obat/hapus/'.$o->OBAT_ID); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus obat ini?')">Hapus</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    <em>Belum ada data obat yang ditambahkan.</em>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-outline-secondary mt-4 mb-5">Logout</a>

</div>

<div class="modal fade" id="tambahObatModal" tabindex="-1" aria-labelledby="tambahObatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= site_url('obat/tambah') ?>" method="post" id="formTambahObat">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahObatModalLabel">Tambah Obat Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_obat" class="form-label">Nama Obat</label>
            <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
          </div>
          <div class="mb-3">
            <label for="jenis" class="form-label">Jenis</label>
            <input type="text" class="form-control" id="jenis" name="jenis" required>
          </div>
          <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="kategori" name="kategori" required>
          </div>
          <div class="mb-3">
            <label for="generic" class="form-label">Generic</label>
            <input type="text" class="form-control" id="generic" name="generic" placeholder="Boleh dikosongkan">
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Boleh dikosongkan"></textarea>
          </div>
          <div class="mb-3">
            <label for="stok" class="form-label">Stok Awal</label>
            <input type="number" class="form-control" id="stok" name="stok" required min="0">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success">Simpan Obat</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editObatModal" tabindex="-1" aria-labelledby="editObatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?= site_url('obat/edit_action') ?>" method="post" id="formEditObat">
        <div class="modal-header">
          <h5 class="modal-title" id="editObatModalLabel">Edit Data Obat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="obat_id" id="edit_obat_id">

          <div class="mb-3">
            <label for="edit_nama_obat" class="form-label">Nama Obat</label>
            <input type="text" class="form-control" id="edit_nama_obat" name="nama_obat" required>
          </div>
          <div class="mb-3">
            <label for="edit_jenis" class="form-label">Jenis</label>
            <input type="text" class="form-control" id="edit_jenis" name="jenis" required>
          </div>
          <div class="mb-3">
            <label for="edit_kategori" class="form-label">Kategori</label>
            <input type="text" class="form-control" id="edit_kategori" name="kategori" required>
          </div>
          <div class="mb-3">
            <label for="edit_generic" class="form-label">Generic</label>
            <input type="text" class="form-control" id="edit_generic" name="generic">
          </div>
          <div class="mb-3">
            <label for="edit_keterangan" class="form-label">Keterangan</label>
            <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="edit_stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="edit_stok" name="stok" required min="0">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-warning">Update Obat</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('edit_obat_id').value = this.getAttribute('data-id');
            document.getElementById('edit_nama_obat').value = this.getAttribute('data-nama');
            document.getElementById('edit_jenis').value = this.getAttribute('data-jenis');
            document.getElementById('edit_kategori').value = this.getAttribute('data-kategori');
            document.getElementById('edit_generic').value = this.getAttribute('data-generic');
            document.getElementById('edit_keterangan').value = this.getAttribute('data-keterangan');
            document.getElementById('edit_stok').value = this.getAttribute('data-stok');
        });
    });
});
</script>

<script>
$(document).ready(function() {
    $('#tabelObat').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "order": [[0, "asc"]]
    });
});
</script>

<?php $this->load->view('footer'); ?>