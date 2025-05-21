# GetHelp - Tutorial Platform for Students

GetHelp is a web platform developed in PHP that offers tutorials and educational resources for college students. The project was converted from static HTML to PHP to allow dynamic functionalities and better code organization.

## Project Structure

```
GetHelp/
├── assets/
│   ├── images/
│   └── videos/
├── css/
│   └── styles.css
├── includes/
│   ├── config.php
│   ├── db.php
│   ├── functions.php
│   ├── header.php
│   └── footer.php
├── install/
│   └── setup_db.php
├── js/
│   └── script.js
├── index.php
├── about.php
├── contact-us.php
├── login.php
├── logout.php
├── register.php
├── showcase.php
├── tutorial.php
├── tutorials.php
├── 404.php
└── README.md
```

## Features

- **Home Page**: Site presentation highlighting popular modules and features.
- **Tutorials**: List of tutorials organized by categories with a filtering system.
- **Tutorial Page**: Detailed display of a specific tutorial.
- **User System**: User login and registration with validation and security.
- **About Us**: Information about the project and team.
- **Contact**: Contact form with PHP validation.

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
   - Password: admin123

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
