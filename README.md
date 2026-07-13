# Bank CMS

A professional, responsive Content Management System (CMS) for banking institutions built with PHP, Bootstrap, and MySQL.

## Features

- ✅ Responsive Design (Mobile, Tablet, Desktop)
- ✅ Professional Carousel for Events & Awards
- ✅ Product/Services Management
- ✅ Job Openings & Applications
- ✅ Admin Dashboard
- ✅ User Authentication & Authorization
- ✅ Contact Form Management
- ✅ Security Features (CSRF, SQL Injection Prevention, XSS Protection)
- ✅ SEO Friendly

## Technology Stack

- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache with .htaccess URL Rewriting

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled
- Composer (optional)

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/gtventic/bank-cms.git
   cd bank-cms
   ```

2. **Create database**
   ```bash
   mysql -u root -p < database/schema.sql
   ```

3. **Configure database**
   Edit `config/constants.php` and update:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_user');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'bank_cms');
   ```

4. **Set permissions**
   ```bash
   chmod 755 uploads/
   chmod 755 uploads/carousel/
   chmod 755 uploads/products/
   chmod 755 uploads/events/
   ```

5. **Access the application**
   - Frontend: `http://localhost/bank-cms/`
   - Admin: `http://localhost/bank-cms/admin.php`
   - Default Admin: `admin@bank.com` / `password`

## File Structure

```
bank-cms/
├── config/
│   ├── database.php       # Database connection
│   ├── constants.php      # Application constants
│   └── config.php         # Helper functions & session
├── classes/
│   ├── Database.php       # Database class
│   ├── User.php          # User authentication
│   ├── Product.php       # Products management
│   ├── Carousel.php      # Carousel management
│   ├── Job.php           # Jobs & applications
│   ├── Event.php         # Events management
│   ├── Award.php         # Awards management
│   └── Contact.php       # Contact messages
├── views/
│   ├── frontend/
│   │   ├── layout.php    # Main layout template
│   │   ├── home.php      # Homepage
│   │   ├── products.php  # Products page
│   │   ├── jobs.php      # Jobs page
│   │   ├── about.php     # About page
│   │   ├── contact.php   # Contact page
│   │   └── governance.php # Governance page
│   └── admin/
│       ├── layout.php
│       ├── dashboard.php
│       └── manage_*.php
├── assets/
│   ├── css/custom.css    # Custom styles
│   └── js/custom.js      # Custom scripts
├── uploads/              # User uploads
├── database/
│   └── schema.sql        # Database schema
├── index.php             # Frontend entry point
├── admin.php             # Admin entry point
├── .htaccess             # URL rewriting
└── README.md
```

## Database Tables

- `users` - Admin and staff accounts
- `products` - Bank products/services
- `carousel_items` - Carousel slides
- `jobs` - Job openings
- `job_applications` - Job applications
- `events` - Bank events
- `awards` - Bank awards
- `contact_messages` - Contact form submissions
- `pages` - Static pages
- `activity_log` - Audit log

## Security Features

- Bcrypt password hashing
- Prepared statements (PDO)
- CSRF token protection
- XSS protection
- SQL injection prevention
- Rate limiting on login
- HTTPS enforcement
- Input validation & sanitization

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email support@bank.com or open an issue on GitHub.

## Changelog

### Version 1.0.0 (Initial Release)
- Initial release with core features
- Responsive design
- Admin dashboard
- Carousel functionality
