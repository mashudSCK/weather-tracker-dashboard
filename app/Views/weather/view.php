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
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white">
                        <i class="bi bi-geo-alt-fill me-2"></i><?= esc($city['city_name']) ?>, <?= esc($city['country_code']) ?>
                    </h2>
                    <a href="<?= base_url('weather') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Weather
                    </a>
                </div>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($weather): ?>
                    <!-- Current Weather -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="bi bi-cloud-sun me-2"></i>Current Weather</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 text-center">
                                            <i class="bi bi-cloud-sun weather-icon text-warning"></i>
                                            <h1 class="display-3 mt-3"><?= number_format($weather['temperature'], 1) ?>°C</h1>
                                            <h5><?= esc($weather['condition']) ?></h5>
                                            <p class="text-muted"><?= esc($weather['description']) ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table table-borderless">
                                                <tr>
                                                    <td><i class="bi bi-thermometer-half text-danger me-2"></i>Feels Like</td>
                                                    <td><strong><?= number_format($weather['feels_like'], 1) ?>°C</strong></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="bi bi-droplet text-info me-2"></i>Humidity</td>
                                                    <td><strong><?= $weather['humidity'] ?>%</strong></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="bi bi-wind text-primary me-2"></i>Wind Speed</td>
                                                    <td><strong><?= number_format($weather['wind_speed'], 1) ?> m/s</strong></td>
                                                </tr>
                                                <tr>
                                                    <td><i class="bi bi-clock text-secondary me-2"></i>Last Updated</td>
                                                    <td><strong><?= date('M d, Y H:i:s', strtotime($weather['fetched_at'])) ?></strong></td>
                                                </tr>
                                            </table>
                                            <a href="<?= base_url('weather/fetch/' . $city['id']) ?>" class="btn btn-success w-100">
                                                <i class="bi bi-arrow-clockwise me-2"></i>Refresh Weather Data
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Temperature History Chart -->
                <?php if (!empty($history)): ?>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Temperature Trend</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="temperatureChart" style="max-height: 400px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- History Table -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Weather History</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date & Time</th>
                                                    <th>Temperature</th>
                                                    <th>Feels Like</th>
                                                    <th>Condition</th>
                                                    <th>Humidity</th>
                                                    <th>Wind Speed</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($history as $record): ?>
                                                    <tr>
                                                        <td><?= date('M d, Y H:i', strtotime($record['fetched_at'])) ?></td>
                                                        <td><span class="badge bg-danger"><?= number_format($record['temperature'], 1) ?>°C</span></td>
                                                        <td><?= number_format($record['feels_like'], 1) ?>°C</td>
                                                        <td><i class="bi bi-cloud me-1"></i><?= esc($record['condition']) ?></td>
                                                        <td><?= $record['humidity'] ?>%</td>
                                                        <td><?= number_format($record['wind_speed'], 1) ?> m/s</td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>No historical data available. Fetch weather data to see trends.
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?php if (!empty($history)): ?>
<script>
    // Prepare data for Chart.js
    const labels = <?= json_encode(array_reverse(array_map(function($h) {
        return date('M d H:i', strtotime($h['fetched_at']));
    }, $history))) ?>;
    
    const temperatures = <?= json_encode(array_reverse(array_map(function($h) {
        return $h['temperature'];
    }, $history))) ?>;
    
    const humidity = <?= json_encode(array_reverse(array_map(function($h) {
        return $h['humidity'];
    }, $history))) ?>;

    // Create chart
    const ctx = document.getElementById('temperatureChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Temperature (°C)',
                data: temperatures,
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                yAxisID: 'y',
                tension: 0.4
            }, {
                label: 'Humidity (%)',
                data: humidity,
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                yAxisID: 'y1',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Temperature & Humidity Over Time'
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Temperature (°C)'
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Humidity (%)'
                    },
                    grid: {
                        drawOnChartArea: false,
                    }
                }
            }
        }
    });
</script>
<?php endif; ?>
<?= $this->endSection() ?>
