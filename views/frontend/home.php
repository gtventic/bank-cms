<?php $title = 'Home - Professional Banking Solutions'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container py-5">
        <h1 class="display-4 fw-bold mb-4">Welcome to Our Bank</h1>
        <p class="lead mb-4">Your trusted partner for all banking and financial solutions</p>
        <a href="<?php echo APP_URL; ?>/products" class="btn btn-warning btn-lg me-3">
            <i class="fas fa-credit-card"></i> Explore Products
        </a>
        <a href="<?php echo APP_URL; ?>/contact" class="btn btn-outline-light btn-lg">
            <i class="fas fa-phone"></i> Get in Touch
        </a>
    </div>
</section>

<!-- Carousel Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5"><i class="fas fa-star"></i> Latest Events & Awards</h2>
        <div id="carouselEvents" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php 
                $carousel = new Carousel();
                $items = $carousel->getActiveItems();
                foreach ($items as $index => $item): 
                ?>
                    <button type="button" data-bs-target="#carouselEvents" data-bs-slide-to="<?php echo $index; ?>" 
                            class="<?php echo $index === 0 ? 'active' : ''; ?>"></button>
                <?php endforeach; ?>
            </div>
            <div class="carousel-inner">
                <?php foreach ($items as $index => $item): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <img src="<?php echo $item['image_path']; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($item['title']); ?>">
                        </div>
                        <div class="col-md-6">
                            <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                            <p class="text-muted"><small><?php echo formatDate($item['created_at'], 'M d, Y'); ?></small></p>
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                            <?php if (!empty($item['link'])): ?>
                            <a href="<?php echo htmlspecialchars($item['link']); ?>" class="btn btn-primary">
                                Learn More <i class="fas fa-arrow-right"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselEvents" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselEvents" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5"><i class="fas fa-cube"></i> Featured Products</h2>
        <div class="row g-4">
            <?php 
            $product = new Product();
            $products = $product->getAllProducts(6);
            foreach ($products as $prod): 
            ?>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($prod['name']); ?></h5>
                        <p class="card-text text-muted"><?php echo htmlspecialchars($prod['category']); ?></p>
                        <p><?php echo htmlspecialchars(substr($prod['description'], 0, 100) . '...'); ?></p>
                        <?php if ($prod['interest_rate']): ?>
                        <p class="card-text">
                            <strong>Interest Rate:</strong> 
                            <span class="badge bg-success"><?php echo htmlspecialchars($prod['interest_rate']); ?>%</span>
                        </p>
                        <?php endif; ?>
                        <a href="<?php echo APP_URL; ?>/products#product-<?php echo $prod['id']; ?>" class="btn btn-primary btn-sm">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="<?php echo APP_URL; ?>/products" class="btn btn-primary btn-lg">
                View All Products <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4">
                <div class="p-4 bg-light rounded">
                    <h3 class="text-primary">50+</h3>
                    <p class="text-muted">Banking Products</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-4 bg-light rounded">
                    <h3 class="text-primary">1M+</h3>
                    <p class="text-muted">Happy Customers</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-4 bg-light rounded">
                    <h3 class="text-primary">25+</h3>
                    <p class="text-muted">Branches</p>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-4 bg-light rounded">
                    <h3 class="text-primary">24/7</h3>
                    <p class="text-muted">Customer Support</p>
                </div>
            </div>
        </div>
    </div>
</section>