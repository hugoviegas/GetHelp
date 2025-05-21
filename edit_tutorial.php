<?php
// ===============================
// edit_tutorial.php - Edit an Existing Tutorial (Mentor/Admin Only)
// ===============================
// This page allows mentors and admins to edit tutorials.
// Students do not have access to this page.

require_once 'includes/config.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
include 'includes/header.php';
// Only mentors and admin can access
if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] !== 'mentor' && $_SESSION['user']['role'] !== 'admin')) {
    // Display access denied message
    echo '<main><div class="container" style="padding:100px 0;text-align:center;"><h1>Access Denied</h1><p>You do not have permission to edit tutorials.</p></div></main>';
    include 'includes/footer.php';
    exit;
}
// Get the category and tutorial ID from the URL
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';
$id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
// Mock: Pre-fill with example data (in real app, fetch from DB)
$tutorial = [
  'title' => 'Sample Tutorial',
  'description' => 'This is a sample tutorial description.',
  'difficulty' => 'Intermediate',
  'duration' => '3 hours'
];
$success = false;
// If the form is submitted, show a success message (mockup only)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = true;
}
?>
<main>
  <div class="container" style="max-width:600px; margin:60px auto;">
    <h1>Edit Tutorial</h1>
    <?php if ($success): ?>
      <!-- Show a success message after form submission -->
      <div class="alert success">Tutorial updated successfully! (Mockup only)</div>
      <a href="tutorials.php?category=<?php echo urlencode($category); ?>" class="btn primary">Back to Category</a>
    <?php else: ?>
      <!-- Tutorial editing form -->
      <form method="post" class="form-card">
        <input type="hidden" name="category" value="<?php echo $category; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($tutorial['title']); ?>" required>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="3" required><?php echo htmlspecialchars($tutorial['description']); ?></textarea>
        </div>
        <div class="form-group">
          <label for="difficulty">Difficulty</label>
          <select id="difficulty" name="difficulty" required>
            <option value="Beginner"<?php if($tutorial['difficulty']==='Beginner') echo ' selected'; ?>>Beginner</option>
            <option value="Intermediate"<?php if($tutorial['difficulty']==='Intermediate') echo ' selected'; ?>>Intermediate</option>
            <option value="Advanced"<?php if($tutorial['difficulty']==='Advanced') echo ' selected'; ?>>Advanced</option>
          </select>
        </div>
        <div class="form-group">
          <label for="duration">Duration</label>
          <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($tutorial['duration']); ?>" required>
        </div>
        <button type="submit" class="btn primary">Save Changes</button>
        <a href="tutorials.php?category=<?php echo urlencode($category); ?>" class="btn secondary" style="margin-left:10px;">Cancel</a>
      </form>
    <?php endif; ?>
  </div>
</main>
<?php include 'includes/footer.php'; ?>