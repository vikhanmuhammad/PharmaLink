<div id="body">
	<h2>Daftar Pegawai</h2>

	<?php if(!empty($pegawai)): ?>
	<table border="1" cellpadding="5" cellspacing="0">
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Password</th>
			<th>Unit Kerja</th>
		</tr>
		<?php foreach($pegawai as $p): ?>
		<tr>
			<td><?php echo $p->PEGAWAI_ID; ?></td>
			<td><?php echo $p->USERNAME; ?></td>
			<td><?php echo $p->PASSWORD; ?></td>
			<td><?php echo $p->NAMA_UNIT; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php else: ?>
	<p>Tidak ada data pegawai.</p>
	<?php endif; ?>
</div>
