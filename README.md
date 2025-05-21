# GetHelp - Tutorial Platform for Students

GetHelp is a web platform developed in PHP that offers tutorials and educational resources for college students. The project was converted from static HTML to PHP to allow dynamic functionalities and better code organization.

## Project Structure

```
GetHelp/
├── assets/
│   ├── fonts/
│   ├── images/
│   │   ├── projectskills.svg
│   │   ├── software_fund.svg
│   │   ├── webdev.svg
│   │   └── projects/
│   │       ├── background-html-css.jpg
│   │       ├── college-student-bg-girl.jpg
│   │       └── college-student.jpg
│   └── videos/
│       └── HTML in 100 Seconds.mp4
├── cookies/
│   ├── get_cookies.php
│   └── setcookies.php
├── css/
│   ├── styles.bkp.css
│   ├── styles.css
│   ├── base/
│   │   ├── _reset.css
│   │   └── _variables.css
│   ├── components/
│   │   ├── _alerts.css
│   │   ├── _burger.css
│   │   ├── _buttons.css
│   │   ├── _captcha.css
│   │   ├── _forms.css
│   │   └── _user-menu.css
│   ├── layouts/
│   │   ├── _container.css
│   │   ├── _footer.css
│   │   └── _navbar.css
│   ├── pages/
│   │   ├── _404.css
│   │   ├── _admin.css
│   │   ├── _cta-section.css
│   │   ├── _features.css
│   │   ├── _feedbacks.css
│   │   ├── _intro.css
│   │   ├── _modules-section.css
│   │   ├── _team.css
│   │   └── _tutorials.css
│   └── utils/
│       ├── _cookie-consent.css
│       ├── _helpers.css
│       └── _responsive.css
├── includes/
│   ├── config.php
│   ├── db.php
│   ├── footer.php
│   ├── functions.php
│   └── header.php
├── js/
│   └── script.js
├── sample/
├── 404.php
├── about.php
├── add_tutorial.php
├── captcha.php
├── contact-us.php
├── diagnostic.php
├── edit_tutorial.php
├── index.php
├── login.php
├── logout.php
├── manage_users.php
├── register.php
├── registration_log.txt
├── tutorial.php
├── tutorials.php
└── README.md
```

## Features

- **Home Page**: Site presentation highlighting popular modules and features.
- **Tutorials**: List of tutorials organized by categories with a filtering system.
- **Tutorial Page**: Detailed display of a specific tutorial.
- **User System**: User login and registration with validation and security.
- **About Us**: Information about the project and team.
- **Contact**: Contact form with PHP validation.
- **Cookie Management**: Added functionality to manage cookies.
- **Admin Panel**: Manage users and tutorials.

## Technical Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache, Nginx, etc.)
- Modern web browser

## Installation

1. Clone the repository:

   ```
   git clone https://github.com/hugoviegas/GetHelp.git
   ```

2. Configure your web server to point to the project directory.

3. Configure the database:

   - Create a MySQL database
   - Update database credentials in `includes/db.php`
   - Access `install/setup_db.php` via browser to create the necessary tables

4. Access the site through the configured server.

5. Use the default credentials to login as administrator:
   - Email: admin@gethelp.com
   - Password: Admin123

## User System

The user system includes the following features:

- **User Registration**: Form with validation for name, email, phone and password
- **Captcha Verification**: Protection against bots during registration
- **Secure Login**: Authentication with password hashing
- **Session Management**: User session control
- **Client-Side Validation**: JavaScript for form validation
- **Server-Side Validation**: PHP to ensure data security

## Development

This project was converted from HTML to PHP to provide:

- Component reuse (header, footer, etc.)
- Form processing
- Dynamic content
- Better code organization and maintenance
- Secure login/registration system

## Author

Hugo Viegas - Student at CCT College Dublin
Student Number: 2024319

## License

This project is developed for educational purposes as part of a Web Development project at CCT College Dublin.
