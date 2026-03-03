<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <span class="nav-link text-muted">
        <?= html_escape($this->session->userdata('full_name')) ?> (<?= html_escape($this->session->userdata('role')) ?>)
      </span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?= site_url('auth/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </li>
  </ul>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= site_url('dashboard') ?>" class="brand-link">
    <span class="brand-text font-weight-light ml-2">SIM Laundry</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <li class="nav-item">
          <a href="<?= site_url('dashboard') ?>" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">TRANSAKSI</li>
        <li class="nav-item">
          <a href="<?= site_url('dirtyrequests') ?>" class="nav-link">
            <i class="nav-icon fas fa-box"></i>
            <p>Linen Kotor</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('cleanorders') ?>" class="nav-link">
            <i class="nav-icon fas fa-truck"></i>
            <p>Linen Bersih</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('damagereports') ?>" class="nav-link">
            <i class="nav-icon fas fa-exclamation-triangle"></i>
            <p>Linen Rusak</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?= site_url('washweights') ?>" class="nav-link">
            <i class="nav-icon fas fa-weight"></i>
            <p>Berat Cucian</p>
          </a>
        </li>

        <?php if (in_array($this->session->userdata('role'), array('admin', 'laundry'))): ?>
          <li class="nav-header">LAPORAN</li>
          <li class="nav-item"><a href="<?= site_url('units') ?>" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Linen kotor</p>
            </a></li>
          <li class="nav-item"><a href="<?= site_url('linentypes') ?>" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>Linen Bersih</p>
            </a></li>
          <li class="nav-item"><a href="<?= site_url('shifts') ?>" class="nav-link">
              <i class="nav-icon fas fa-clock"></i>
              <p>Berat Linen</p>
            </a></li>
        <?php endif; ?>

        <?php if ($this->session->userdata('role') === 'admin'): ?>
          <li class="nav-header">MASTER</li>
          <li class="nav-item"><a href="<?= site_url('units') ?>" class="nav-link">
              <i class="nav-icon fas fa-hospital"></i>
              <p>Unit/Ruangan</p>
            </a></li>
          <li class="nav-item"><a href="<?= site_url('linentypes') ?>" class="nav-link">
              <i class="nav-icon fas fa-tags"></i>
              <p>Jenis Linen</p>
            </a></li>
          <li class="nav-item"><a href="<?= site_url('shifts') ?>" class="nav-link">
              <i class="nav-icon fas fa-clock"></i>
              <p>Shift</p>
            </a></li>
        <?php endif; ?>

      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"><?= isset($title) ? $title : '' ?></h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <?php if ($this->session->flashdata('msg')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('msg') ?></div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('err')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('err') ?></div>
      <?php endif; ?>