<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-md-block sidebar collapse">
            <div class="position-sticky pt-3">
                <div class="text-center mb-4">
                    <i class="bi bi-cloud-sun-fill text-white" style="font-size: 3rem;"></i>
                    <h5 class="text-white mt-2">Weather Tracker</h5>
                    <small class="text-muted">Welcome, <?= esc(session()->get('username')) ?></small>
                    <br>
                    <span class="badge bg-<?= session()->get('role') == 'admin' ? 'danger' : 'info' ?> mt-2">
                        <?= ucfirst(session()->get('role')) ?>
                    </span>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('dashboard') ?>">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('weather') ?>">
                            <i class="bi bi-cloud-sun me-2"></i>Weather
                        </a>
                    </li>
                    <?php if (session()->get('role') == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('cities') ?>">
                                <i class="bi bi-geo-alt me-2"></i>Manage Cities
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('users') ?>">
                                <i class="bi bi-people me-2"></i>Manage Users
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item mt-3">
                        <a class="nav-link text-danger" href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4">
            <div class="pt-3 pb-2 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="text-white mb-4"><i class="bi bi-cloud-sun me-2"></i>Weather Information</h2>
                    <?php if (session()->get('role') == 'admin'): ?>
                        <a href="<?= base_url('weather/fetch-all') ?>" class="btn btn-success">
                            <i class="bi bi-arrow-clockwise me-2"></i>Fetch All Weather
                        </a>
                    <?php endif; ?>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <?php if (!empty($weatherData)): ?>
                        <?php foreach ($weatherData as $data): ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="card-title mb-0">
                                                <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                                <?= esc($data['city']['city_name']) ?>
                                            </h5>
                                            <span class="badge bg-secondary"><?= esc($data['city']['country_code']) ?></span>
                                        </div>

                                        <?php if ($data['weather']): ?>
                                            <div class="text-center my-4">
                                                <i class="bi bi-cloud-sun weather-icon text-warning"></i>
                                                <h2 class="mt-3"><?= number_format($data['weather']['temperature'], 1) ?>°C</h2>
                                                <p class="text-muted mb-1"><?= esc($data['weather']['condition']) ?></p>
                                                <small class="text-muted"><?= esc($data['weather']['description']) ?></small>
                                            </div>

                                            <div class="row text-center mt-3">
                                                <div class="col-6">
                                                    <i class="bi bi-droplet text-info"></i>
                                                    <p class="mb-0"><small>Humidity</small></p>
                                                    <strong><?= $data['weather']['humidity'] ?>%</strong>
                                                </div>
                                                <div class="col-6">
                                                    <i class="bi bi-wind text-primary"></i>
                                                    <p class="mb-0"><small>Wind Speed</small></p>
                                                    <strong><?= number_format($data['weather']['wind_speed'], 1) ?> m/s</strong>
                                                </div>
                                            </div>

                                            <p class="text-muted text-center mt-3 mb-0">
                                                <small>Updated: <?= date('M d, Y H:i', strtotime($data['weather']['fetched_at'])) ?></small>
                                            </p>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                <i class="bi bi-info-circle me-2"></i>No data available
                                            </div>
                                        <?php endif; ?>

                                        <div class="mt-3 d-grid gap-2">
                                            <a href="<?= base_url('weather/view/' . $data['city']['id']) ?>" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye me-2"></i>View Details
                                            </a>
                                            <a href="<?= base_url('weather/fetch/' . $data['city']['id']) ?>" class="btn btn-success btn-sm">
                                                <i class="bi bi-arrow-clockwise me-2"></i>Refresh Data
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>No cities available. Please add cities first.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>
<?= $this->endSection() ?>
