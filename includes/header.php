<!-- ===============================
     header.php - Site Header and Navigation
     ===============================
     This file contains the HTML for the site's header and navigation bar.
     It is included at the top of every page for consistency.
     The navigation changes based on whether the user is logged in and their role.
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo get_page_title(); ?></title>
    <!-- This gives the page Title: GetHelp -->
    <!-- Link external JavaScript and CSS files -->
    <link rel="stylesheet" href="css/styles.css">
    <!-- adding a google font to the entire page -->
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap"
      rel="stylesheet"
    />
  </head>
  <body>
    <!-- Fixed NavBar - Stays always at the top of the page -->
    <header>
      <nav class="navbar">
        <div class="container">
          <a href="index.php" class="logo">GetHelp</a>
          <div class="nav-actions">
            <!-- Burger Icon for Mobile -->
            <button class="burger" id="burger-menu" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
              <span class="burger-bar"></span>
              <span class="burger-bar"></span>
              <span class="burger-bar"></span>
            </button>
          </div>
          <!-- Main Navigation Links (Desktop) -->
          <ul class="nav-links">
            <li><a href="index.php"<?php echo active_class('index'); ?>>Home</a></li>
            <li><a href="tutorials.php"<?php echo active_class('tutorials'); ?>>Tutorials</a></li>
            <li><a href="contact-us.php"<?php echo active_class('contact-us'); ?>>Contact Us</a></li>
            <li><a href="about.php"<?php echo active_class('about'); ?>>About Us</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
              <?php if(isset($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <li><a href="manage_users.php"<?php echo active_class('manage_users'); ?>>Manage Users</a></li>
              <?php endif; ?>
              <li><a href="#" class="user-menu">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
              <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
              <li><a href="login.php"<?php echo active_class('login'); ?>>Login</a></li>
              <li><a href="register.php"<?php echo active_class('register'); ?>>Register</a></li>
            <?php endif; ?>
          </ul>
          <!-- Mobile Sidebar Menu (hidden by default) -->
          <div class="mobile-menu-sidebar" id="mobile-menu" aria-hidden="true">
            <ul>
              <li><a href="index.php"<?php echo active_class('index'); ?>>Home</a></li>
              <li><a href="tutorials.php"<?php echo active_class('tutorials'); ?>>Tutorials</a></li>
              <li><a href="contact-us.php"<?php echo active_class('contact-us'); ?>>Contact Us</a></li>
              <li><a href="about.php"<?php echo active_class('about'); ?>>About Us</a></li>
              <?php if(isset($_SESSION['user_id'])): ?>
                <?php if(isset($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                  <li><a href="manage_users.php"<?php echo active_class('manage_users'); ?>>Manage Users</a></li>
                <?php endif; ?>
                <li><a href="#" class="user-menu">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
                <li><a href="logout.php">Logout</a></li>
              <?php else: ?>
                <li><a href="login.php"<?php echo active_class('login'); ?>>Login</a></li>
                <li><a href="register.php"<?php echo active_class('register'); ?>>Register</a></li>
              <?php endif; ?>
            </ul>
          </div>
          <!-- Overlay for sidebar -->
          <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>
        </div>
      </nav>
    </header>