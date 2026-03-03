<div class="card">
  <div class="card-body">
    <form method="post">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="request_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Jam Pengambilan</label>
            <input type="time" name="request_time" class="form-control" value="<?= date('H:i') ?>" required>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label>Unit/Ruangan</label>
            <?php if ($this->session->userdata('role') === 'unit'): ?>
              <input class="form-control" value="(otomatis dari user)" disabled>
              <input type="hidden" name="unit_id" value="<?= (int)$this->session->userdata('unit_id') ?>">
            <?php else: ?>
              <select name="unit_id" class="form-control" required>
                <option value="">- pilih -</option>
                <?php foreach($units as $u): ?>
                  <option value="<?= $u->id ?>"><?= html_escape($u->name) ?></option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="form-group">
        <label>Catatan</label>
        <input type="text" name="notes" class="form-control" placeholder="opsional">
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-2">Item Linen</h5>
        <button type="button" class="btn btn-success btn-sm btn-add-row"><i class="fas fa-plus"></i> Tambah Baris</button>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered">
          <thead><tr><th>Jenis Linen</th><th width="120">Qty</th><th>Keterangan</th><th width="60"></th></tr></thead>
          <tbody id="items-body"></tbody>
        </table>
      </div>

      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-secondary" href="<?= site_url('dirtyrequests') ?>">Kembali</a>
    </form>
  </div>
</div>

<script type="text/template" id="row-template">
<tr>
  <td>
    <select name="items[__i__][linen_type_id]" class="form-control" required>
      <option value="">- pilih -</option>
      <?php foreach($linen as $l): ?>
        <option value="<?php echo $l->id; ?>"><?php echo html_escape($l->name); ?></option>
      <?php endforeach; ?>
    </select>
  </td>
  <td><input type="number" name="items[__i__][qty]" class="form-control" min="1" required></td>
  <td><input type="text" name="items[__i__][remark]" class="form-control"></td>
  <td class="text-center"><button type="button" class="btn btn-danger btn-sm btn-remove-row">&times;</button></td>
</tr>
</script>


<script>
  // auto add 1 row
  document.addEventListener('DOMContentLoaded', function(){
    var btn = document.querySelector('.btn-add-row');
    if(btn) btn.click();
  });
</script>
