<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Superadmin</title>
</head>
<body>
    <h1>Selamat datang, Superadmin <?= $this->session->userdata('USERNAME'); ?>!</h1>
    <p>Ini halaman khusus untuk Superadmin.</p>
    <a href="<?= site_url('auth/logout'); ?>">Logout</a>
</body>
</html>
