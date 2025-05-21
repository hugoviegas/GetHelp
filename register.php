<?php
// ===============================
// register.php - User Registration Page
// ===============================
// This page allows new students to create an account on GetHelp.
// It includes server-side validation, a simple captcha, and feedback for the user.

// Include configuration and database files
require_once 'includes/config.php';
require_once 'includes/db.php';

// Handle register form submission and validate all fields
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Store the current captcha for comparison
    $current_captcha = $_SESSION['captcha'];
    
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $captcha = sanitize_input($_POST['captcha']);
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } elseif (!preg_match('/^[A-Za-z\s]+$/', $name)) {
        $error = 'Name should contain only letters and spaces.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please provide a valid email.';
    } elseif (!preg_match('/^\d{9,10}$/', $phone)) {
        $error = 'Phone number must contain 9 to 10 digits.';
    } elseif (trim($captcha) !== $current_captcha) {
        $error = 'Incorrect verification code.';
        // Generate a new captcha
        $_SESSION['captcha'] = null;
    } else {
        // Check if email already exists
        $sql = "SELECT * FROM users WHERE email = ?";
        $existing_user = db_get_row($sql, [$email]);
        
        if ($existing_user) {
            $error = 'This email is already in use. Please choose another.';
            // Generate a new captcha
            $_SESSION['captcha'] = null;
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $user_data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => $hashed_password
            ];
            
            $result = db_insert('users', $user_data);
            
            if ($result) {
                // Auto login the user after successful registration
                $_SESSION['user_id'] = $result; // db_insert already returns the user ID
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['logged_in'] = true; // Ensure login status is set
                // Fetch the full user record (including role) and store in session
                $new_user = db_get_row('SELECT * FROM users WHERE id = ?', [$result]);
                if ($new_user) {
                    $_SESSION['user'] = $new_user;
                }
                
                // Log successful registration
                file_put_contents('registration_log.txt', "SUCCESS: User $name ($email) registered with ID $result\n", FILE_APPEND);
                
                // Set success message as fallback
                $success = 'Registration successful! Redirecting to home page...';
                
                // Redirect to home page - using JavaScript for more reliable redirect
                echo "<script>window.location.href = 'index.php';</script>";
                // Fallback for browsers with JavaScript disabled
                header("Location: index.php");
                exit(); // Prevent further execution
            } else {
                // Log error with basic information
                file_put_contents('registration_log.txt', "ERROR: Database insertion failed for $email\n", FILE_APPEND);
                
                $error = 'Error during registration. Please try again.';
                // Generate a new captcha
                $_SESSION['captcha'] = null;
            }
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<main>
  <section class="form-section">
    <div class="container">
      <div class="form-container">
        <h2>Register</h2>
        <!-- Show error or success messages -->
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <!-- Registration form for new users -->
        <form id="register-form" method="POST" action="register.php">
          <div class="form-group">
            <label for="name" class="required">Name</label>
            <input 
              type="text" 
              id="name" 
              name="name" 
              placeholder="Your full name" 
              value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
              required
            />
            <small>Enter your full name (letters and spaces only)</small>
          </div>
          
          <div class="form-group">
            <label for="email" class="required">Email</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              placeholder="Your email" 
              value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
              required
            />
            <small>This will be your username for login</small>
          </div>
          
          <div class="form-group">
            <label for="phone" class="required">Phone</label>
            <input 
              type="text" 
              id="phone" 
              name="phone" 
              placeholder="Your phone number (numbers only)" 
              value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
              required
            />
            <small>Enter numbers only (9 to 10 digits)</small>
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
            <small>Use a strong password with letters, numbers, and special characters</small>
          </div>
          
          <div class="form-group">
            <label for="confirm_password" class="required">Confirm Password</label>
            <input 
              type="password" 
              id="confirm_password" 
              name="confirm_password" 
              placeholder="Confirm your password" 
              required
            />
            <small>Enter the same password again</small>
          </div>
          
          <div class="form-group captcha-group">
            <label for="captcha" class="required">Verification Code</label>
            <div class="captcha-container">
              <img id="captcha-img" src="captcha.php" alt="CAPTCHA" />
              <button type="button" id="refresh-captcha" class="refresh-captcha" aria-label="Refresh Captcha">↻</button>
              <input 
                type="text" 
                id="captcha" 
                name="captcha" 
                placeholder="Enter the code shown above" 
                required
              />
            </div>
            <small>Enter the code shown above for verification</small>
          </div>
          
          <div class="form-buttons">
            <button type="submit" class="btn primary">Register</button>
          </div>
          
          <div class="form-footer">
            <p>Already have an account? <a href="login.php">Sign in</a></p>
          </div>
        </form>
      </div>
      
      <!-- Info section: Explains registration and privacy -->
      <div class="help-info">
        <h3>Information</h3>
        <p>Create your account to access all GetHelp resources. Registration is quick and simple.</p>
        <h3>Privacy Policy</h3>
        <p>Your data is safe with us. We don't share your information with third parties without your permission.</p>
        <h3>Need help?</h3>
        <p>If you're having trouble registering, contact us through the <a href="contact-us.php">Contact</a> page.</p>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>