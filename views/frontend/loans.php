<?php $title = 'Loans & Financing'; ?>

<div class="hero-section">
    <div class="container py-5">
        <h1>Our Loan Products</h1>
        <p class="lead">Flexible financing solutions tailored to your needs</p>
    </div>
</div>

<div class="container py-5">
    <!-- Loans Filter -->
    <div class="row mb-5">
        <div class="col-12">
            <ul class="nav nav-tabs mb-4" id="loanTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-loans-tab" data-bs-toggle="tab" data-bs-target="#all-loans" type="button" role="tab">All Loans</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="agricultural-tab" data-bs-toggle="tab" data-bs-target="#agricultural" type="button" role="tab">Agricultural</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="commercial-tab" data-bs-toggle="tab" data-bs-target="#commercial" type="button" role="tab">Commercial</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">Personal</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specialized-tab" data-bs-toggle="tab" data-bs-target="#specialized" type="button" role="tab">Specialized</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Loans Grid -->
    <div class="tab-content" id="loanTabContent">
        <!-- All Loans Tab -->
        <div class="tab-pane fade show active" id="all-loans" role="tabpanel">
            <div class="row g-4">
                <?php 
                $loans = [
                    [
                        'id' => 1,
                        'name' => 'Agricultural Loan',
                        'category' => 'Agricultural',
                        'description' => 'Financing for farming operations, equipment, and agricultural development.',
                        'interest_rate' => '6.5',
                        'loan_amount' => '50,000 - 500,000',
                        'icon' => '🌾'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Todo Ani Loan',
                        'category' => 'Agricultural',
                        'description' => 'Specialized loan program for agricultural entrepreneurs and farmers.',
                        'interest_rate' => '7.0',
                        'loan_amount' => '25,000 - 250,000',
                        'icon' => '🥘'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Bridge Financing for Onion Farmers and Traders',
                        'category' => 'Agricultural',
                        'description' => 'Short-term financing for onion farmers and traders to bridge cash flow gaps.',
                        'interest_rate' => '5.5',
                        'loan_amount' => '10,000 - 100,000',
                        'icon' => '🧅'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Bridge Financing for Seed Growers',
                        'category' => 'Agricultural',
                        'description' => 'Financing solution for seed growers to support their operations and growth.',
                        'interest_rate' => '6.0',
                        'loan_amount' => '20,000 - 200,000',
                        'icon' => '🌱'
                    ],
                    [
                        'id' => 5,
                        'name' => 'Commercial Loan',
                        'category' => 'Commercial',
                        'description' => 'Comprehensive financing for business operations, expansion, and working capital.',
                        'interest_rate' => '8.5',
                        'loan_amount' => '100,000 - 2,000,000',
                        'icon' => '🏢'
                    ],
                    [
                        'id' => 6,
                        'name' => 'Todo Negosoyo Loan',
                        'category' => 'Commercial',
                        'description' => 'Business financing program supporting small to medium enterprises (SMEs).',
                        'interest_rate' => '9.0',
                        'loan_amount' => '50,000 - 1,000,000',
                        'icon' => '💼'
                    ],
                    [
                        'id' => 7,
                        'name' => 'Jewelry Loan',
                        'category' => 'Personal',
                        'description' => 'Quick cash loans with jewelry as collateral for immediate financial needs.',
                        'interest_rate' => '12.0',
                        'loan_amount' => '5,000 - 500,000',
                        'icon' => '💎'
                    ],
                    [
                        'id' => 8,
                        'name' => 'Multi-Purpose Loan',
                        'category' => 'Personal',
                        'description' => 'Flexible personal loan for various purposes including education, home improvement, and more.',
                        'interest_rate' => '10.5',
                        'loan_amount' => '10,000 - 500,000',
                        'icon' => '🎯'
                    ],
                    [
                        'id' => 9,
                        'name' => 'Salary Loan',
                        'category' => 'Personal',
                        'description' => 'Quick and convenient loan for salaried employees with flexible repayment terms.',
                        'interest_rate' => '9.5',
                        'loan_amount' => '5,000 - 300,000',
                        'icon' => '💰'
                    ]
                ];

                foreach ($loans as $loan): 
                ?>
                <div class="col-lg-3 col-md-6" id="loan-<?php echo $loan['id']; ?>">
                    <div class="card loan-card h-100 text-center shadow-sm">
                        <div class="loan-icon mb-3">
                            <div style="font-size: 3rem;"><?php echo $loan['icon']; ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($loan['name']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($loan['category']); ?></p>
                            <p class="card-text small mb-3"><?php echo htmlspecialchars($loan['description']); ?></p>
                            <div class="loan-details mb-3">
                                <p class="mb-1"><strong>Interest Rate:</strong> <span class="badge bg-danger"><?php echo htmlspecialchars($loan['interest_rate']); ?>%</span></p>
                                <p class="mb-0 small"><strong>Loan Amount:</strong> ₱<?php echo htmlspecialchars($loan['loan_amount']); ?></p>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#loanModal<?php echo $loan['id']; ?>">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Agricultural Loans Tab -->
        <div class="tab-pane fade" id="agricultural" role="tabpanel">
            <div class="row g-4">
                <?php 
                foreach ($loans as $loan): 
                    if (strpos(strtolower($loan['category']), 'agricultural') !== false):
                ?>
                <div class="col-lg-3 col-md-6" id="loan-<?php echo $loan['id']; ?>">
                    <div class="card loan-card h-100 text-center shadow-sm">
                        <div class="loan-icon mb-3">
                            <div style="font-size: 3rem;"><?php echo $loan['icon']; ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($loan['name']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($loan['category']); ?></p>
                            <p class="card-text small mb-3"><?php echo htmlspecialchars($loan['description']); ?></p>
                            <div class="loan-details mb-3">
                                <p class="mb-1"><strong>Interest Rate:</strong> <span class="badge bg-danger"><?php echo htmlspecialchars($loan['interest_rate']); ?>%</span></p>
                                <p class="mb-0 small"><strong>Loan Amount:</strong> ₱<?php echo htmlspecialchars($loan['loan_amount']); ?></p>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#loanModal<?php echo $loan['id']; ?>">
                                Apply Now
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

        <!-- Commercial Loans Tab -->
        <div class="tab-pane fade" id="commercial" role="tabpanel">
            <div class="row g-4">
                <?php 
                foreach ($loans as $loan): 
                    if (strpos(strtolower($loan['category']), 'commercial') !== false):
                ?>
                <div class="col-lg-3 col-md-6" id="loan-<?php echo $loan['id']; ?>">
                    <div class="card loan-card h-100 text-center shadow-sm">
                        <div class="loan-icon mb-3">
                            <div style="font-size: 3rem;"><?php echo $loan['icon']; ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($loan['name']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($loan['category']); ?></p>
                            <p class="card-text small mb-3"><?php echo htmlspecialchars($loan['description']); ?></p>
                            <div class="loan-details mb-3">
                                <p class="mb-1"><strong>Interest Rate:</strong> <span class="badge bg-danger"><?php echo htmlspecialchars($loan['interest_rate']); ?>%</span></p>
                                <p class="mb-0 small"><strong>Loan Amount:</strong> ₱<?php echo htmlspecialchars($loan['loan_amount']); ?></p>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#loanModal<?php echo $loan['id']; ?>">
                                Apply Now
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

        <!-- Personal Loans Tab -->
        <div class="tab-pane fade" id="personal" role="tabpanel">
            <div class="row g-4">
                <?php 
                foreach ($loans as $loan): 
                    if (strpos(strtolower($loan['category']), 'personal') !== false):
                ?>
                <div class="col-lg-3 col-md-6" id="loan-<?php echo $loan['id']; ?>">
                    <div class="card loan-card h-100 text-center shadow-sm">
                        <div class="loan-icon mb-3">
                            <div style="font-size: 3rem;"><?php echo $loan['icon']; ?></div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo htmlspecialchars($loan['name']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($loan['category']); ?></p>
                            <p class="card-text small mb-3"><?php echo htmlspecialchars($loan['description']); ?></p>
                            <div class="loan-details mb-3">
                                <p class="mb-1"><strong>Interest Rate:</strong> <span class="badge bg-danger"><?php echo htmlspecialchars($loan['interest_rate']); ?>%</span></p>
                                <p class="mb-0 small"><strong>Loan Amount:</strong> ₱<?php echo htmlspecialchars($loan['loan_amount']); ?></p>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top">
                            <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#loanModal<?php echo $loan['id']; ?>">
                                Apply Now
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

        <!-- Specialized Loans Tab -->
        <div class="tab-pane fade" id="specialized" role="tabpanel">
            <div class="row g-4">
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Additional Loan Products</h4>
                        <p>We also offer specialized loan products for unique financial needs. Contact us for more information on:</p>
                        <ul>
                            <li>Real Estate & Home Loans</li>
                            <li>Auto & Vehicle Financing</li>
                            <li>Educational Loans</li>
                            <li>Business Expansion Loans</li>
                            <li>Emergency Fund Loans</li>
                        </ul>
                        <hr>
                        <p class="mb-0">For detailed information, please visit our branches or call our loan specialists.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .loan-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .loan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .loan-icon {
        padding: 20px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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

    .nav-tabs {
        border-bottom: 2px solid #e0e0e0;
    }

    .nav-tabs .nav-link {
        color: #333333 !important;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        font-weight: 500;
        padding: 10px 20px;
        margin-right: 5px;
    }

    .nav-tabs .nav-link:hover {
        color: #667eea !important;
        border-bottom-color: #667eea;
        background-color: #f5f5f5;
    }

    .nav-tabs .nav-link.active {
        background-color: transparent;
        color: #667eea !important;
        border-bottom-color: #667eea;
        font-weight: 700;
    }

    .loan-details {
        font-size: 0.9rem;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.4rem 0.6rem;
    }
</style>
