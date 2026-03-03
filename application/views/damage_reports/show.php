<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-3"><b>No</b><br><?= html_escape($hdr->report_no) ?></div>
      <div class="col-md-3"><b>Tanggal</b><br><?= $hdr->report_date ?></div>
      <div class="col-md-3"><b>Unit</b><br><?= html_escape($hdr->unit_name) ?></div>
      <div class="col-md-3"><b>Status</b><br><span class="badge badge-info"><?= $hdr->status ?></span></div>
    </div>
    <p class="mt-2 mb-0"><b>Catatan:</b> <?= html_escape($hdr->notes) ?></p>

    <?php if (in_array($this->session->userdata('role'), ['admin','unit'], true) && $hdr->status==='OPEN'): ?>
      <div class="mt-3">
        <a class="btn btn-success btn-sm" href="<?= site_url('damagereports/ack/'.$hdr->id) ?>">Acknowledge</a>
      </div>
    <?php endif; ?>

    <hr>
    <h5>Item</h5>
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead><tr><th>Jenis Linen</th><th width="160">Kategori</th><th width="120">Qty</th><th>Keterangan</th></tr></thead>
        <tbody>
          <?php foreach($items as $i): ?>
          <tr>
            <td><?= html_escape($i->linen_name) ?></td>
            <td><?= html_escape($i->category) ?></td>
            <td><?= (int)$i->qty ?></td>
            <td><?= html_escape($i->remark) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <a class="btn btn-secondary" href="<?= site_url('damagereports') ?>">Kembali</a>
  </div>
</div>
