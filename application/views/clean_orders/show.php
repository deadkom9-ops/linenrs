<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3"><b>No</b><br><?= html_escape($hdr->order_no) ?></div>
      <div class="col-md-3"><b>Tanggal</b><br><?= $hdr->order_date ?></div>
      <div class="col-md-3"><b>Unit</b><br><?= html_escape($hdr->unit_name) ?></div>
      <div class="col-md-3"><b>Status</b><br><span class="badge badge-info"><?= $hdr->status ?></span></div>
    </div>
    <p class="mt-2 mb-0"><b>Catatan:</b> <?= html_escape($hdr->notes) ?></p>

    <?php if (in_array($this->session->userdata('role'), ['admin','laundry'], true)): ?>
      <div class="mt-3">
        <?php if ($hdr->status === 'SUBMITTED'): ?>
          <a class="btn btn-success btn-sm" href="<?= site_url('cleanorders/approve/'.$hdr->id) ?>">Approve</a>
          <a class="btn btn-danger btn-sm" href="<?= site_url('cleanorders/reject/'.$hdr->id) ?>">Reject</a>
        <?php elseif ($hdr->status === 'APPROVED'): ?>
          <a class="btn btn-primary btn-sm" href="<?= site_url('cleanorders/deliver/'.$hdr->id) ?>">Deliver</a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <hr>
    <h5>Item</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead><tr><th>Jenis Linen</th><th width="120">Qty</th><th>Keterangan</th></tr></thead>
        <tbody>
          <?php foreach($items as $i): ?>
          <tr>
            <td><?= html_escape($i->linen_name) ?></td>
            <td><?= (int)$i->qty ?></td>
            <td><?= html_escape($i->remark) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <a class="btn btn-secondary" href="<?= site_url('cleanorders') ?>">Kembali</a>
  </div>
</div>
