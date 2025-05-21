<?php
// ===============================
// login.php - User Login Page
// ===============================
// This page allows existing students to log in to GetHelp.
// It includes server-side validation and feedback for the user.

// Include configuration and database files
require_once 'includes/config.php';
require_once 'includes/db.php';

// Handle login form submission and validate fields
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    
    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        // Check if user exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $user = db_get_row($sql, [$email]);
        
        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = $user; // Store full user array including role
            
            $success = 'Login successful! Redirecting...';
            
            // Redirect immediately - using JavaScript for more reliable redirect
            echo "<script>window.location.href = 'index.php';</script>";
            // Fallback for browsers with JavaScript disabled
            header("Location: index.php");
            exit(); // Important to prevent further execution
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<main>
  <section class="form-section">
    <div class="container">
      <div class="form-container">
        <h2>Login</h2>
        <!-- Show error or success messages -->
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <!-- Login form for existing users -->
        <form id="login-form" method="POST" action="login.php">
          <div class="form-group">
            <label for="email" class="required">Email</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              placeholder="Your email" 
              required
            />
            <small>Enter the email used for registration</small>
          </div>
          <div class="form-group">
            <label for="password" class="required">Password</label>
            <input 
              type="password" 
              id="password" 
              name="password" 
              placeholder="Your password" 
              required
            />
          </div>
          <div class="form-buttons">
            <button type="submit" class="btn primary">Sign In</button>
          </div>
          <div class="form-footer">
            <p>Don't have an account? <a href="register.php">Register</a></p>
          </div>
        </form>
      </div>
      <!-- Info section: Explains login and help -->
      <div class="help-info">
        <h3>Information</h3>
        <p>Login to access all GetHelp resources. If you don't have an account yet, <a href="register.php">click here to register</a>.</p>
        <h3>Need help?</h3>
        <p>If you're having trouble accessing your account, contact us through the <a href="contact-us.php">Contact</a> page.</p>
      </div>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>

<style>
/* Add padding at the top of the login page */
.form-section {
  padding-top: 60px;
}
</style>