<?php 
// Include configuration file
require_once 'includes/config.php';
?>
<?php include 'includes/header.php'; ?>

<main>
  <section class="error-section">
    <div class="container">
      <div class="error-content">
        <h1>404</h1>
        <h2>Page Not Found</h2>
        <p>Sorry, the page you are looking for does not exist or has been moved.</p>
        <div class="error-actions">
          <a href="index.php" class="btn primary">Return to Home Page</a>
          <a href="contact-us.php" class="btn secondary">Contact Us</a>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?> 