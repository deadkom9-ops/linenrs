<div class="card">
  <div class="card-body">
    <form method="post">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="report_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Shift</label>
            <select name="shift_id" class="form-control" required>
              <option value="">- pilih -</option>
              <?php foreach($shifts as $s): ?>
                <option value="<?= $s->id ?>"><?= html_escape($s->name) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Jam Pengambilan</label>
            <input type="time" name="pickup_time" class="form-control" value="<?= date('H:i') ?>" required>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label>Unit/Ruangan</label>
            <select name="unit_id" class="form-control" required>
              <option value="">- pilih -</option>
              <?php foreach($units as $u): ?>
                <option value="<?= $u->id ?>"><?= html_escape($u->name) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Berat (kg)</label>
            <input type="number" step="0.01" min="0" name="weight_kg" class="form-control" required>
          </div>
        </div>
         <div class="col-md-3">
    <div class="form-group">
      <label>Kategori Pencucian</label>
      <select name="wash_category" class="form-control" required>
        <option value="NON_INFEKSIUS">Non Infeksius</option>
        <option value="INFEKSIUS">Infeksius</option>
      </select>
    </div>
  </div>
        <div class="col-md-3">
          <div class="form-group">
            <label>Keterangan</label>
            <input type="text" name="notes" class="form-control" placeholder="opsional">
          </div>
        </div>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-secondary" href="<?= site_url('washweights') ?>">Kembali</a>
    </form>
  </div>
</div>
