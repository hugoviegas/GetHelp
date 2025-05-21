<?php
// ===============================
// manage_users.php - Admin User Management Page
// ===============================
// This page allows admin users to view and change user roles.
// Only admins can access this page. Students and mentors cannot access it.

session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once 'includes/config.php';

// If the session does not have a user but has a user_id, try to fetch the user from the database
if (!isset($_SESSION['user']) && isset($_SESSION['user_id'])) {
    $user = db_get_row('SELECT * FROM users WHERE id = ?', [$_SESSION['user_id']]);
    if ($user) {
        $_SESSION['user'] = $user;
    }
}

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
    echo '<div style="padding:40px;text-align:center;color:red;">Access denied. Only admin users can access this page.</div>';
    exit;
}

// Handle role update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['role'])) {
    $user_id = intval($_POST['user_id']);
    $role = $_POST['role'];
    // Only allow valid roles
    if (in_array($role, ['student', 'mentor', 'admin'])) {
        // Prevent admin from changing their own role
        if ($user_id !== $_SESSION['user']['id']) {
            db_update('users', ['role' => $role], 'id = ?', [$user_id]);
        }
    }
}

// Fetch all users from the database
$users = db_get_rows('SELECT * FROM users', []);

include 'includes/header.php';
?>
<div class="admin-table-container">
    <h2>User Management</h2>
    <div class="table-responsive">
    <table class="admin-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['phone']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td>
                <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                <!-- Form to change the user's role -->
                <form method="post">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <select name="role" class="input-select">
                        <option value="student" <?= $user['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                        <option value="mentor" <?= $user['role'] === 'mentor' ? 'selected' : '' ?>>Mentor</option>
                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <button type="submit" class="btn primary small">Update</button>
                </form>
                <?php else: ?>
                (You)
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
