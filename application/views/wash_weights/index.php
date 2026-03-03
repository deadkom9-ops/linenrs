<div class="card">
  <div class="card-header">
    <?php if (in_array($this->session->userdata('role'), ['admin','laundry'], true)): ?>
      <a href="<?= site_url('washweights/create') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Input
      </a>
    <?php endif; ?>
  </div>
  <div class="card-body table-responsive">
   <table id="datatable" class="table table-bordered table-hover">
      <thead><tr><th>Tanggal</th><th>Shift</th><th>Jam</th><th>Unit</th><th>Berat (kg)</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php foreach($rows as $r): ?>
        <tr>
          <td><?= $r->report_date ?></td>
          <td><?= html_escape($r->shift_name) ?></td>
          <td><?= $r->pickup_time ?></td>
          <td><?= html_escape($r->unit_name) ?></td>
          <td><?= number_format((float)$r->weight_kg, 0) ?></td>
          <td> <?php if (in_array($this->session->userdata('role'), array('admin','laundry'))): ?>
              <a class="btn btn-warning btn-sm" href="<?= site_url('washweights/edit/'.$r->id) ?>">Edit</a>
              <a class="btn btn-info btn-sm" href="<?= site_url('washweights/proses/'.$r->id) ?>">Proses</a>
             <!--  <a class="btn btn-success btn-sm" href="<?= site_url('washweights/kering/'.$r->id) ?>">Proses Pengeringan</a> -->
              <a class="btn btn-danger btn-sm"
                 href="<?php echo site_url('washweights/delete/'.$r->id); ?>"
                 onclick="return confirm('Yakin hapus request ini?');">
                 Hapus
              </a>
            <?php endif; ?>
          </td></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
