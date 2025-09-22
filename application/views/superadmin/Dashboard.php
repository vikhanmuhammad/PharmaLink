<?php $this->load->view('header', ['title' => 'Dashboard']); ?>

<div class="container mt-4">

    <h1 class="display-5">Selamat datang, <span class="text-success">Superadmin <?= $this->session->userdata('USERNAME'); ?>!</span></h1>

    <div class="card my-4 border-success">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">Menu Navigasi</h3>
        </div>
        <div class="card-body">
            <div class="list-group">
                <a href="<?= site_url('auth/logout'); ?>" class="list-group-item list-group-item-action list-group-item-danger">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="h5 mb-0">Manajemen Data Pasien</h3>
            
            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPasienModal">
                + Tambah Pasien
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="pasienTable" class="table table-striped table-bordered table-hover mb-0">
                    <thead class="table-success">
                        <tr>
                            <th>ID Pasien</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pasien)) : ?>
                            <?php foreach ($pasien as $p): ?>
                                <tr>
                                    <td class="align-middle"><?= $p->PASIEN_ID; ?></td>
                                    <td class="align-middle"><?= $p->NAMA; ?></td>
                                    <td class="align-middle"><?= $p->TGL_LAHIR; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    <em>Tidak ada data pasien yang terdaftar.</em>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div> <div class="modal fade" id="tambahPasienModal" tabindex="-1" aria-labelledby="tambahPasienModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      
      <form action="<?= site_url('superadmin/tambah_pasien_action') ?>" method="post">
        
        <div class="modal-header">
          <h5 class="modal-title" id="tambahPasienModalLabel">Tambah Data Pasien Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">
          <p class="text-muted">Masukkan detail pasien baru di bawah ini. ID Pasien akan dibuat secara otomatis oleh sistem.</p>
          
          <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap Pasien</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Budi Santoso" required>
          </div>
          
          <div class="mb-3">
            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" required>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan Pasien</button>
        </div>
      
      </form>
      </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $('#pasienTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "order": [[0, "asc"]]
    });
});
</script>

<?php $this->load->view('footer'); ?>