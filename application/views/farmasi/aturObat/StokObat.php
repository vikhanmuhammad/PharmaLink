<!DOCTYPE html>
<html>
    <head>
        <title>Manajemen Stok Obat</title>
    </head>

    <body>
    <h2>Manajemen Stok Obat</h2>
        <a href="<?php echo site_url('obat/tambah'); ?>">Tambah Obat</a>
        <a href="<?php echo site_url('farmasi'); ?>">Dashboard</a>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Nama Obat</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Generic</th>
                <th>Keterangan</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php if (!empty($obat)): ?>
                <?php foreach ($obat as $o): ?>
                <tr>
                    <td><?php echo $o->OBAT_ID; ?></td>
                    <td><?php echo $o->NAMA_OBAT; ?></td>
                    <td><?php echo $o->JENIS; ?></td>
                    <td><?php echo $o->KATEGORI; ?></td>
                    <td><?php echo $o->GENERIC; ?></td>
                    <td><?php echo $o->KETERANGAN; ?></td>
                    <td><?php echo $o->STOK; ?></td>
                    <td>
                        <a href="<?php echo site_url('obat/edit/'.$o->OBAT_ID); ?>">Edit</a> |
                        <a href="<?php echo site_url('obat/hapus/'.$o->OBAT_ID); ?>" onclick="return confirm('Hapus obat ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align:center;">Data kosong</td>
                </tr>
            <?php endif; ?>
        </table>
        <br>
        <a href="<?php echo site_url('auth/logout'); ?>">Logout</a>
    </body>
</html>


