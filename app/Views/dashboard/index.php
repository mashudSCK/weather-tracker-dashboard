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
                        <a class="nav-link active" href="<?= base_url('dashboard') ?>">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('weather') ?>">
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
                <h2 class="text-white mb-4"><i class="bi bi-speedometer2 me-2"></i>Dashboard Overview</h2>

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

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="bi bi-geo-alt" style="font-size: 2.5rem;"></i>
                                <h3 class="mt-3"><?= $totalCities ?></h3>
                                <p class="mb-0">Total Cities</p>
                            </div>
                        </div>
                    </div>
                    <?php if (session()->get('role') == 'admin'): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card stat-card">
                                <div class="card-body text-center">
                                    <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                                    <h3 class="mt-3"><?= $totalUsers ?></h3>
                                    <p class="mb-0">Total Users</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-4 mb-3">
                        <div class="card stat-card">
                            <div class="card-body text-center">
                                <i class="bi bi-database" style="font-size: 2.5rem;"></i>
                                <h3 class="mt-3"><?= $totalWeatherLogs ?></h3>
                                <p class="mb-0">Weather Logs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Weather Data -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Weather Updates</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recentWeather)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>City</th>
                                            <th>Temperature</th>
                                            <th>Condition</th>
                                            <th>Humidity</th>
                                            <th>Fetched At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($recentWeather as $weather): ?>
                                            <tr>
                                                <td>
                                                    <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                                    <strong><?= esc($weather['city_name']) ?></strong>, <?= esc($weather['country_code']) ?>
                                                </td>
                                                <td><span class="badge bg-info"><?= number_format($weather['temperature'], 1) ?>°C</span></td>
                                                <td><i class="bi bi-cloud me-1"></i><?= esc($weather['condition']) ?></td>
                                                <td><?= $weather['humidity'] ?>%</td>
                                                <td><?= date('M d, Y H:i', strtotime($weather['fetched_at'])) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>No weather data available yet. Start by fetching weather data!
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <a href="<?= base_url('weather') ?>" class="btn btn-primary me-2">
                                    <i class="bi bi-cloud-sun me-2"></i>View Weather
                                </a>
                                <?php if (session()->get('role') == 'admin'): ?>
                                    <a href="<?= base_url('weather/fetch-all') ?>" class="btn btn-success me-2">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Fetch All Weather Data
                                    </a>
                                    <a href="<?= base_url('cities/create') ?>" class="btn btn-info me-2">
                                        <i class="bi bi-plus-circle me-2"></i>Add New City
                                    </a>
                                    <a href="<?= base_url('register') ?>" class="btn btn-warning">
                                        <i class="bi bi-person-plus me-2"></i>Add New User
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?= $this->endSection() ?>
