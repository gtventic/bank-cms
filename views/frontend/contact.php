<?php $title = 'Contact Us'; ?>

<div class="hero-section">
    <div class="container py-5">
        <h1>Contact Us</h1>
        <p class="lead">We're here to help and answer any questions</p>
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-md-6">
            <h2>Send us a Message</h2>
            <form method="POST" action="<?php echo APP_URL; ?>/submit-contact">
                <input type="hidden" name="<?php echo CSRF_TOKEN_NAME; ?>" value="<?php echo getCSRFToken(); ?>">
                
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone">
                </div>
                
                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>
                
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>
        
        <div class="col-md-6">
            <h2>Get in Touch</h2>
            
            <div class="mb-4">
                <h5><i class="fas fa-map-marker-alt text-primary"></i> Address</h5>
                <p>123 Banking Street<br>Financial District<br>City, State 12345</p>
            </div>
            
            <div class="mb-4">
                <h5><i class="fas fa-phone text-primary"></i> Phone</h5>
                <p>
                    <a href="tel:+18008008000" class="text-decoration-none">+1-800-800-8000</a><br>
                    <small class="text-muted">Monday - Friday, 9AM - 5PM</small>
                </p>
            </div>
            
            <div class="mb-4">
                <h5><i class="fas fa-envelope text-primary"></i> Email</h5>
                <p>
                    <a href="mailto:info@bank.com" class="text-decoration-none">info@bank.com</a><br>
                    <a href="mailto:support@bank.com" class="text-decoration-none">support@bank.com</a>
                </p>
            </div>
            
            <div class="mb-4">
                <h5><i class="fas fa-clock text-primary"></i> Business Hours</h5>
                <p>
                    Monday - Friday: 9:00 AM - 5:00 PM<br>
                    Saturday: 10:00 AM - 3:00 PM<br>
                    Sunday: Closed
                </p>
            </div>
            
            <div>
                <h5>Follow Us</h5>
                <a href="#" class="btn btn-sm btn-outline-primary me-2"><i class="fab fa-facebook"></i></a>
                <a href="#" class="btn btn-sm btn-outline-primary me-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="btn btn-sm btn-outline-primary me-2"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="btn btn-sm btn-outline-primary"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>