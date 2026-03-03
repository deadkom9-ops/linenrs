<div class="card">
  <div class="card-header">
    <?php if (in_array($this->session->userdata('role'), ['admin','laundry'], true)): ?>
      <a href="<?= site_url('damagereports/create') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Input
      </a>
    <?php endif; ?>
  </div>
  <div class="card-body table-responsive">
   <table id="datatable" class="table table-bordered table-hover">
      <thead><tr><th>No</th><th>Tgl</th><th>Unit</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        <?php foreach($rows as $r): ?>
        <tr>
          <td><?= html_escape($r->report_no) ?></td>
          <td><?= $r->report_date ?></td>
          <td><?= html_escape($r->unit_name) ?></td>
          <td><span class="badge badge-info"><?= $r->status ?></span></td>
          <td><a class="btn btn-secondary btn-sm" href="<?= site_url('damagereports/show/'.$r->id) ?>">Detail</a>
            <?php if (in_array($this->session->userdata('role'), array('admin','laundry'))): ?>
              <a class="btn btn-danger btn-sm"
                 href="<?php echo site_url('damagereports/delete/'.$r->id); ?>"
                 onclick="return confirm('Yakin hapus request ini?');">
                 Hapus
              </a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
