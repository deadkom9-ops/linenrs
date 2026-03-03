<div class="card">
  <div class="card-body">
    <form method="post">
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="<?= isset($row) ? html_escape($row->name) : '' ?>" required>
      </div>
              <div class="form-group">
      <label>Aktif</label>
      <select name="is_active" class="form-control">
        <option value="1" <?= isset($row) && (int)$row->is_active===1 ? 'selected' : '' ?>>Ya</option>
        <option value="0" <?= isset($row) && (int)$row->is_active===0 ? 'selected' : '' ?>>Tidak</option>
      </select>
    </div>

      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-secondary" href="<?= site_url('linentypes') ?>">Kembali</a>
    </form>
  </div>
</div>
