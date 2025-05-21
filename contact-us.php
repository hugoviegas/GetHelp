<?php
// ===============================
// contact-us.php - Contact/Help Request Page
// ===============================
// This page allows students to request help with their college modules.
// It includes a form with validation and a section explaining how the help process works.

// Include configuration file (for settings, database, etc)
require_once 'includes/config.php';

// Initialize variables for the form fields and error/success messages
$name = $email = $phone = $module = $message = '';
$errors = [];
$success_message = '';

// Process form submission and validate each field
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $errors['name'] = "Name is required";
    } else {
        $name = sanitize_input($_POST["name"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $errors['name'] = "Only letters and spaces are allowed";
        }
    }
    
    // Validate email
    if (empty($_POST["email"])) {
        $errors['email'] = "Email is required";
    } else {
        $email = sanitize_input($_POST["email"]);
        // Check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        }
    }
    
    // Validate phone
    if (empty($_POST["phone"])) {
        $errors['phone'] = "Phone is required";
    } else {
        $phone = sanitize_input($_POST["phone"]);
        // Check if phone only contains numbers and is the right length
        if (!preg_match("/^\d{9,10}$/", $phone)) {
            $errors['phone'] = "Phone must be 9 or 10 digits";
        }
    }
    
    // Get module (optional)
    $module = !empty($_POST["module"]) ? sanitize_input($_POST["module"]) : '';
    
    // Validate message
    if (empty($_POST["message"])) {
        $errors['message'] = "Message is required";
    } else {
        $message = sanitize_input($_POST["message"]);
    }
    
    // If no errors, process the form
    if (empty($errors)) {
        // Here you would typically save to a database or send an email
        // For this example, we'll just set a success message
        $success_message = "Your message has been sent successfully! We will contact you soon.";
        
        // Clear form fields after successful submission
        $name = $email = $phone = $module = $message = '';
    }
}
?>
<?php include 'includes/header.php'; ?>

<!-- Main Content -->
<main>
  <!-- Intro Section: Explains the purpose of the help request page -->
  <section class="intro">
    <div class="container">
      <h1>Request Help</h1>
      <p class="subtitle">Need assistance with your college modules?</p>
      <p class="description">
        Fill out the form below with your details and specific needs. Our
        team of experienced tutors will get back to you as soon as possible
        to provide personalized help with your projects or assignments.
      </p>
    </div>
  </section>

  <!-- Form Section: Contains the help request form and info -->
  <section class="form-section">
    <div class="container">
      <div class="form-container">
        <h2>Contact Form</h2>
        <!-- Show error or success messages -->
        <div id="message-container"></div>
        <div class="messages-container">
          <?php if (!empty($errors)): ?>
            <div class="error-box">
              <ul>
                <?php foreach ($errors as $error): ?>
                  <li><?php echo $error; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <?php if (!empty($success_message)): ?>
            <div class="success-box">
              <?php echo $success_message; ?>
            </div>
          <?php endif; ?>
        </div>
        <!-- The help request form -->
        <form id="help-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div class="form-group">
            <label for="name" class="required">Full Name:</label>
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Enter your full name"
              value="<?php echo $name; ?>"
            />
            <small>Only alphabetic characters and spaces allowed</small>
            <?php if (isset($errors['name'])): ?>
              <div class="error-box"><?php echo $errors['name']; ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="email" class="required">Email:</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Enter your email address"
              value="<?php echo $email; ?>"
            />
            <?php if (isset($errors['email'])): ?>
              <div class="error-box"><?php echo $errors['email']; ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="phone" class="required">Phone Number:</label>
            <input
              type="tel"
              id="phone"
              name="phone"
              placeholder="Enter your phone number"
              value="<?php echo $phone; ?>"
            />
            <small>Must be 9 or 10 digits (only numbers allowed)</small>
            <?php if (isset($errors['phone'])): ?>
              <div class="error-box"><?php echo $errors['phone']; ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label for="module">Module:</label>
            <select id="module" name="module">
              <option value="" <?php echo empty($module) ? 'selected' : ''; ?>>Select a module</option>
              <option value="web-development" <?php echo $module === 'web-development' ? 'selected' : ''; ?>>Web Development</option>
              <option value="project-skills" <?php echo $module === 'project-skills' ? 'selected' : ''; ?>>
                Project Skills & Professionalism
              </option>
              <option value="software-fundamentals" <?php echo $module === 'software-fundamentals' ? 'selected' : ''; ?>>
                Software Development Fundamentals
              </option>
              <option value="networking" <?php echo $module === 'networking' ? 'selected' : ''; ?>>
                Networking & Virtualisation
              </option>
              <option value="algorithms" <?php echo $module === 'algorithms' ? 'selected' : ''; ?>>Algorithms and Constructs</option>
              <option value="other" <?php echo $module === 'other' ? 'selected' : ''; ?>>Other</option>
            </select>
          </div>

          <div class="form-group">
            <label for="message" class="required">Message:</label>
            <textarea
              id="message"
              name="message"
              rows="5"
              placeholder="Describe what you need help with..."
            ><?php echo $message; ?></textarea>
            <?php if (isset($errors['message'])): ?>
              <div class="error-box"><?php echo $errors['message']; ?></div>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn primary">Submit Request</button>
        </form>
      </div>
      <!-- Info section: Explains how the help process works and why to choose GetHelp -->
      <div class="help-info">
        <h3>How It Works</h3>
        <ol>
          <li>Fill out the form with your details and specific needs.</li>
          <li>Our team will review your request and match you with the right tutor.</li>
          <li>We'll contact you within 24 hours to arrange a session.</li>
          <li>Get personalized help and improve your understanding of the subject.</li>
        </ol>

        <h3>Why Choose GetHelp?</h3>
        <ul>
          <li>Experienced tutors who understand college modules</li>
          <li>Personalized assistance tailored to your needs</li>
          <li>Flexible scheduling to fit your timetable</li>
          <li>Comprehensive support for a wide range of subjects</li>
        </ul>
      </div>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>

<style>
/* Replace alert with styled error box and update input colors */
.error-box {
  background-color: #f8d7da;
  color: #721c24;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
  border: 1px solid #f5c6cb;
}
.success-box {
  background-color: #d4edda;
  color: #155724;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 20px;
  border: 1px solid #c3e6cb;
}
input, textarea {
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 5px;
}
input:focus, textarea:focus {
  border-color: #007bff;
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
</style>