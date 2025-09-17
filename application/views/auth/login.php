<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Farmasi</title>
</head>
<body>
    <h2>Login Sistem Farmasi RS</h2>

    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red;"><?= $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <form method="post" action="<?= site_url('auth/login'); ?>">
        <label>Username</label>
        <input type="text" name="username" required><br><br>

        <label>Password</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
