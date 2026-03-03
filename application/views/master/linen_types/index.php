<div class="card">
  <div class="card-header">
    <a href="<?= site_url('linentypes/create') ?>" class="btn btn-primary btn-sm">
      <i class="fas fa-plus"></i> Tambah
    </a>
  </div>
  <div class="card-body table-responsive">
    <table id="datatable" class="table table-bordered table-hover">
      <thead><tr><th>ID</th><th>Nama</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php foreach($rows as $r): ?>
        <tr>
          <td><?= $r->id ?></td>
          <td><?= html_escape($r->name) ?></td>
          <td>
            <a class="btn btn-warning btn-sm" href="<?= site_url('linentypes/edit/'.$r->id) ?>">Edit</a>
            <a class="btn btn-danger btn-sm" href="<?= site_url('linentypes/delete/'.$r->id) ?>" onclick="return confirm('Hapus?')">Hapus</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
