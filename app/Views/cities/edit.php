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
                        <a class="nav-link" href="<?= base_url('weather') ?>">
                            <i class="bi bi-cloud-sun me-2"></i>Weather
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('cities') ?>">
                            <i class="bi bi-geo-alt me-2"></i>Manage Cities
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('users') ?>">
                            <i class="bi bi-people me-2"></i>Manage Users
                        </a>
                    </li>
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
                    <h2 class="text-white"><i class="bi bi-pencil me-2"></i>Edit City</h2>
                    <a href="<?= base_url('cities') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to Cities
                    </a>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Update City Information</h5>
                            </div>
                            <div class="card-body">
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                <li><?= esc($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('cities/update/' . $city['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    
                                    <div class="mb-3">
                                        <label for="city_name" class="form-label">City Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="city_name" name="city_name" 
                                               value="<?= old('city_name', $city['city_name']) ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country_code" class="form-label">Country Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="country_code" name="country_code" 
                                               value="<?= old('country_code', $city['country_code']) ?>" required maxlength="10">
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="bi bi-check-circle me-2"></i>Update City
                                        </button>
                                        <a href="<?= base_url('cities') ?>" class="btn btn-secondary">
                                            <i class="bi bi-x-circle me-2"></i>Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?= $this->endSection() ?>
