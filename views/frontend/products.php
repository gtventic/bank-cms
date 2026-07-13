<?php $title = 'Products & Services'; ?>

<div class="hero-section">
    <div class="container py-5">
        <h1>Our Products & Services</h1>
        <p class="lead">Comprehensive banking solutions tailored for you</p>
    </div>
</div>

<div class="container py-5">
    <!-- Products Filter -->
    <div class="row mb-5">
        <div class="col-12">
            <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">All Products</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="savings-tab" data-bs-toggle="tab" data-bs-target="#savings" type="button" role="tab">Savings Accounts</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="checking-tab" data-bs-toggle="tab" data-bs-target="#checking" type="button" role="tab">Checking Accounts</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="investments-tab" data-bs-toggle="tab" data-bs-target="#investments" type="button" role="tab">Investments</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="loans-tab" data-bs-toggle="tab" data-bs-target="#loans" type="button" role="tab">Loans</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="tab-content" id="productTabContent">
        <!-- All Products Tab -->
        <div class="tab-pane fade show active" id="all" role="tabpanel">
            <div class="row g-4">
                <?php 
                $product = new Product();
                $products = $product->getAllProducts();
                if (empty($products)) {
                    $products = [
                        [
                            'id' => 1,
                            'name' => 'Ordinary Savings Account',
                            'category' => 'Savings',
                            'description' => 'Start your savings journey with our basic savings account designed for everyday banking needs.',
                            'interest_rate' => '2.5',
                            'minimum_amount' => '500',
                            'icon' => '💰'
                        ],
                        [
                            'id' => 2,
                            'name' => 'Savings Account w/ Auto-Transfer',
                            'category' => 'Savings',
                            'description' => 'Automatically transfer funds at regular intervals to grow your savings effortlessly.',
                            'interest_rate' => '3.0',
                            'minimum_amount' => '1000',
                            'icon' => '🔄'
                        ],
                        [
                            'id' => 3,
                            'name' => 'Basic Deposit Account',
                            'category' => 'Deposits',
                            'description' => 'A straightforward deposit account for secure fund management and easy access.',
                            'interest_rate' => '1.5',
                            'minimum_amount' => '250',
                            'icon' => '📋'
                        ],
                        [
                            'id' => 4,
                            'name' => 'Time Deposit Account',
                            'category' => 'Investments',
                            'description' => 'Lock in your funds for a fixed period and earn higher interest rates.',
                            'interest_rate' => '5.5',
                            'minimum_amount' => '5000',
                            'icon' => '⏱️'
                        ],
                        [
                            'id' => 5,
                            'name' => 'Smart Savings Account',
                            'category' => 'Savings',
                            'description' => 'Intelligent savings with flexible terms and competitive interest rates for smart savers.',
                            'interest_rate' => '4.0',
                            'minimum_amount' => '2000',
                            'icon' => '🧠'
                        ],
                        [
                            'id' => 6,
                            'name' => 'Checking Account',
                            'category' => 'Checking',
                            'description' => 'Essential checking account with unlimited transactions and low fees.',
                            'interest_rate' => '0.5',
                            'minimum_amount' => '100',
                            'icon' => '✓'
                        ],
                        [
                            'id' => 7,
                            'name' => 'Checking Account w/ Auto-Transfer',
                            'category' => 'Checking',
                            'description' => 'Convenient checking account with automatic transfer features for bill payments.',
                            'interest_rate' => '0.75',
                            'minimum_amount' => '500',
                            'icon' => '🔀'
                        ],
                        [
                            'id' => 8,
                            'name' => 'Bigtime Savings Account',
                            'category' => 'Savings',
                            'description' => 'Premium savings account for major depositors with exclusive benefits and high interest rates.',
                            'interest_rate' => '6.0',
                            'minimum_amount' => '10000',
                            'icon' => '🏆'
                        ]
                    ];
                }
                foreach ($products as $prod): 
                ?>
                <div class="col-lg-3 col-md-6" id="product-<?php echo $prod['id']; ?>">
                    <div class="card product-card h-100 text-center shadow-sm">
                        <div class="product-icon mb-3">
                            <div style="font-size: 3rem;"><?php echo $prod['icon'] ?? '🏦'; ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($prod['name']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($prod['category']); ?></p>
                            <p class="card-text small mb-3"><?php echo htmlspecialchars($prod['description']); ?></p>
                            <div class="product-details mb-3">
                                <?php if (!empty($prod['interest_rate'])): ?>
                                <p class="mb-1"><strong>Rate:</strong> <span class="badge bg-success"><?php echo htmlspecialchars($prod['interest_rate']); ?>%</span></p>
                                <?php endif; ?>
                                <?php if (!empty($prod['minimum_amount'])): ?>
                                <p class="mb-0 small"><strong>Min:</strong> $<?php echo number_format($prod['minimum_amount'], 2); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $prod['id']; ?>">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Savings Accounts Tab -->
        <div class="tab-pane fade" id="savings" role="tabpanel">
            <div class="row g-4">
                <?php 
                foreach ($products as $prod): 
                    if (strpos(strtolower($prod['category']), 'saving') !== false):
                ?>
                <div class="col-lg-3 col-md-6" id="product-<?php echo $prod['id']; ?>">
                    <div class="card product-card h-100 text-center shadow-sm">
                        <div class="product-icon mb-3">
                            <div style="font-size: 3rem;"><?php echo $prod['icon'] ?? '🏦'; ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($prod['name']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($prod['category']); ?></p>
                            <p class="card-text small mb-3"><?php echo htmlspecialchars($prod['description']); ?></p>
                            <div class="product-details mb-3">
                                <?php if (!empty($prod['interest_rate'])): ?>
                                <p class="mb-1"><strong>Rate:</strong> <span class="badge bg-success"><?php echo htmlspecialchars($prod['interest_rate']); ?>%</span></p>
                                <?php endif; ?>
                                <?php if (!empty($prod['minimum_amount'])): ?>
                                <p class="mb-0 small"><strong>Min:</strong> $<?php echo number_format($prod['minimum_amount'], 2); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $prod['id']; ?>">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>

        <!-- Checking Accounts Tab -->
        <div class="tab-pane fade" id="checking" role="tabpanel">
            <div class="row g-4">
                <?php 
                foreach ($products as $prod): 
                    if (strpos(strtolower($prod['category']), 'checking') !== false):
                ?>
                <div class="col-lg-3 col-md-6" id="product-<?php echo $prod['id']; ?>">
                    <div class="card product-card h-100 text-center shadow-sm">
                        <div class="product-icon mb-3">
                            <div style="font-size: 3rem;"><?php echo $prod['icon'] ?? '🏦'; ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($prod['name']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($prod['category']); ?></p>
                            <p class="card-text small mb-3"><?php echo htmlspecialchars($prod['description']); ?></p>
                            <div class="product-details mb-3">
                                <?php if (!empty($prod['interest_rate'])): ?>
                                <p class="mb-1"><strong>Rate:</strong> <span class="badge bg-success"><?php echo htmlspecialchars($prod['interest_rate']); ?>%</span></p>
                                <?php endif; ?>
                                <?php if (!empty($prod['minimum_amount'])): ?>
                                <p class="mb-0 small"><strong>Min:</strong> $<?php echo number_format($prod['minimum_amount'], 2); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $prod['id']; ?>">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>

        <!-- Investments Tab -->
        <div class="tab-pane fade" id="investments" role="tabpanel">
            <div class="row g-4">
                <?php 
                foreach ($products as $prod): 
                    if (strpos(strtolower($prod['category']), 'investment') !== false || strpos(strtolower($prod['category']), 'deposit') !== false):
                ?>
                <div class="col-lg-3 col-md-6" id="product-<?php echo $prod['id']; ?>">
                    <div class="card product-card h-100 text-center shadow-sm">
                        <div class="product-icon mb-3">
                            <div style="font-size: 3rem;"><?php echo $prod['icon'] ?? '🏦'; ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($prod['name']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($prod['category']); ?></p>
                            <p class="card-text small mb-3"><?php echo htmlspecialchars($prod['description']); ?></p>
                            <div class="product-details mb-3">
                                <?php if (!empty($prod['interest_rate'])): ?>
                                <p class="mb-1"><strong>Rate:</strong> <span class="badge bg-success"><?php echo htmlspecialchars($prod['interest_rate']); ?>%</span></p>
                                <?php endif; ?>
                                <?php if (!empty($prod['minimum_amount'])): ?>
                                <p class="mb-0 small"><strong>Min:</strong> $<?php echo number_format($prod['minimum_amount'], 2); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#productModal<?php echo $prod['id']; ?>">
                                Learn More
                            </button>
                        </div>
                    </div>
                </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
        </div>

        <!-- Loans Tab -->
        <div class="tab-pane fade" id="loans" role="tabpanel">
            <div class="row g-4">
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Coming Soon</h4>
                        <p>Our loan products are coming soon. Please check back later for more information.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .product-icon {
        padding: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .hero-section h1 {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .nav-tabs .nav-link {
        color: #667eea;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link:hover {
        border-bottom-color: #667eea;
    }

    .nav-tabs .nav-link.active {
        background-color: transparent;
        color: #667eea;
        border-bottom-color: #667eea;
        font-weight: 600;
    }

    .product-details {
        font-size: 0.9rem;
    }
</style>
