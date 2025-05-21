<?php
// ===============================
// add_tutorial.php - Add a New Tutorial (Mentor/Admin Only)
// ===============================
// This page allows mentors and admins to add new tutorials to the platform.
// Students do not have access to this page.

require_once 'includes/config.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
include 'includes/header.php';
// Only mentors and admin can access
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'mentor' && $_SESSION['user']['role'] !== 'admin')) {
    // Display access denied message
    echo '<main><div class="container" style="padding:100px 0;text-align:center;"><h1>Access Denied</h1><p>You do not have permission to add tutorials.</p></div></main>';
    include 'includes/footer.php';
    exit;
}
// Get the category from the URL if present
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';
$success = false;
// If the form is submitted, show a success message (mockup only)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = true;
}
?>
<main>
  <div class="container" style="max-width:600px; margin:60px auto;">
    <h1>Add Tutorial</h1>
    <?php if ($success): ?>
      <!-- Show a success message after form submission -->
      <div class="alert success">Tutorial added successfully! (Mockup only)</div>
      <a href="tutorials.php?category=<?php echo urlencode($category); ?>" class="btn primary">Back to Category</a>
    <?php else: ?>
      <!-- Tutorial creation form -->
      <form method="post" class="form-card">
        <input type="hidden" name="category" value="<?php echo $category; ?>">
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <label for="difficulty">Difficulty</label>
          <select id="difficulty" name="difficulty" required>
            <option value="Beginner">Beginner</option>
            <option value="Intermediate">Intermediate</option>
            <option value="Advanced">Advanced</option>
          </select>
        </div>
        <div class="form-group">
          <label for="duration">Duration</label>
          <input type="text" id="duration" name="duration" placeholder="e.g. 3 hours" required>
        </div>
        <button type="submit" class="btn primary">Add Tutorial</button>
        <a href="tutorials.php?category=<?php echo urlencode($category); ?>" class="btn secondary" style="margin-left:10px;">Cancel</a>
      </form>
    <?php endif; ?>
  </div>
</main>
<?php include 'includes/footer.php'; ?>