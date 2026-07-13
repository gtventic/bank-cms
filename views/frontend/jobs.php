<?php $title = 'Job Openings'; ?>

<div class="hero-section">
    <div class="container py-5">
        <h1>Career Opportunities</h1>
        <p class="lead">Join our team and grow with us</p>
    </div>
</div>

<div class="container py-5">
    <?php 
    $job = new Job();
    $jobs = $job->getAllJobs(20);
    ?>
    
    <?php if (empty($jobs)): ?>
    <div class="alert alert-info text-center">
        <p>No job openings available at the moment. Please check back later.</p>
    </div>
    <?php else: ?>
    <div class="row g-4">
        <?php foreach ($jobs as $j): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title"><?php echo htmlspecialchars($j['title']); ?></h5>
                            <p class="text-muted mb-2">
                                <i class="fas fa-building"></i> <?php echo htmlspecialchars($j['department']); ?>
                                <span class="ms-3"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($j['location']); ?></span>
                            </p>
                            <p><?php echo htmlspecialchars(substr($j['description'], 0, 200) . '...'); ?></p>
                        </div>
                        <div class="col-md-4 text-end">
                            <p class="mb-2">
                                <span class="badge bg-primary"><?php echo htmlspecialchars($j['employment_type']); ?></span>
                            </p>
                            <?php if ($j['salary_range']): ?>
                            <p class="text-muted mb-3"><strong><?php echo htmlspecialchars($j['salary_range']); ?></strong></p>
                            <?php endif; ?>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal<?php echo $j['id']; ?>">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>