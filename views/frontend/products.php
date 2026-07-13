<?php $title = 'Products & Services'; ?>

<div class="hero-section">
    <div class="container py-5">
        <h1>Our Products & Services</h1>
        <p class="lead">Comprehensive banking solutions tailored for you</p>
    </div>
</div>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">All Products</a>
                <a href="#" class="list-group-item list-group-item-action">Savings Accounts</a>
                <a href="#" class="list-group-item list-group-item-action">Loans</a>
                <a href="#" class="list-group-item list-group-item-action">Investments</a>
                <a href="#" class="list-group-item list-group-item-action">Credit Cards</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row g-4">
                <?php 
                $product = new Product();
                $products = $product->getAllProducts(12);
                foreach ($products as $prod): 
                ?>
                <div class="col-md-6" id="product-<?php echo $prod['id']; ?>">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($prod['name']); ?></h5>
                            <p class="text-muted mb-3"><?php echo htmlspecialchars($prod['category']); ?></p>
                            <p class="card-text"><?php echo htmlspecialchars($prod['description']); ?></p>
                            <div class="mb-3">
                                <?php if ($prod['interest_rate']): ?>
                                <p class="mb-1"><strong>Interest Rate:</strong> <span class="badge bg-success"><?php echo htmlspecialchars($prod['interest_rate']); ?>%</span></p>
                                <?php endif; ?>
                                <?php if ($prod['minimum_amount']): ?>
                                <p class="mb-0"><strong>Min. Amount:</strong> $<?php echo number_format($prod['minimum_amount'], 2); ?></p>
                                <?php endif; ?>
                            </div>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $prod['id']; ?>">
                                Get Started
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>