<?php $this->load->view('header', ['title' => 'Masuk']); ?>

<style>
  body, html {
    height: 100%;
  }
  .container-login {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100%;
  }
</style>

<div class="container-login">
  <div class="card border-primary" style="width: 25rem;">
    
    <div class="card-header bg-primary text-white text-center">
      <h2 class="h4 mb-0">Login Sistem Farmasi</h2>
    </div>

    <div class="card-body">
      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" role="alert">
          <?= $this->session->flashdata('error'); ?>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= site_url('auth/login'); ?>">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required autofocus>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="d-grid mt-4">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
      </div>

  </div>
</div>

<?php $this->load->view('footer'); ?>