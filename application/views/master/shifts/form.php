<div class="card">
  <div class="card-body">
    <form method="post">
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="<?= isset($row) ? html_escape($row->name) : '' ?>" required>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-secondary" href="<?= site_url('shifts') ?>">Kembali</a>
    </form>
  </div>
</div>
