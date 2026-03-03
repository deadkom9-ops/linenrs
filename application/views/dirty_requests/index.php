<div class="card">
  <div class="card-header">
    <?php if (in_array($this->session->userdata('role'), ['admin','unit'], true)): ?>
      <a href="<?= site_url('dirtyrequests/create') ?>" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Input
      </a>
    <?php endif; ?>
  </div>
  <div class="card-body table-responsive">
    <table id="datatable" class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No</th><th>Tgl</th><th>Jam</th><th>Unit</th><th>Status</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($rows as $r): ?>
        <tr>
          <td><?= html_escape($r->request_no) ?></td>
          <td><?= $r->request_date ?></td>
          <td><?= $r->request_time ?></td>
          <td><?= html_escape($r->unit_name) ?></td>
          <td><span class="badge badge-info"><?= $r->status ?></span></td>
          <td>
            <a class="btn btn-secondary btn-sm" href="<?= site_url('dirtyrequests/show/'.$r->id) ?>">Detail</a> | 

              <?php if (in_array($this->session->userdata('role'), array('admin','laundry'))): ?>
              <a class="btn btn-danger btn-sm"
                 href="<?php echo site_url('dirtyrequests/delete/'.$r->id); ?>"
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
