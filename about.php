<?php
// ===============================
// about.php - About Page
// ===============================
// This page explains the purpose of GetHelp and introduces the team.
// It is meant to help students understand who built the platform and why.

// Include configuration file (for settings, database, etc)
require_once 'includes/config.php';
?>
<?php include 'includes/header.php'; ?>

<main>
  <!-- Intro section: Describes the project and its mission -->
  <section class="intro light-gray">
    <div class="container">
      <h1>About Us</h1>
      <p class="description">
        GetHelp is a project developed by a student from CCT College Dublin.
        My goal is to provide a platform where students can find help with
        their college modules, get assistance with their projects and
        improve their learning experience.
      </p>
      <p class="description">
        We offer a wide range of tutorials, guides and personalized help for
        subjects like Web Development, Software Fundamentals, Java, Maths
        and many others. Our team is composed of experienced students and
        professionals who are ready to help you succeed in your college
        journey.
      </p>
      <p class="description">
        If you need help with a specific topic or project, feel free to
        contact us and we will do our best to assist you. We are here to
        help you achieve your academic goals and become a successful
        student.
      </p>
    </div>
  </section>
  
  <?php
  // Team members are defined in an array for easy management
  $team_members = [
      [
          'name' => 'Hugo Viegas',
          'role' => 'Founder & Lead Developer',
          'bio' => 'Computer Science student at CCT College Dublin with a passion for web development and helping other students.',
          'image' => 'assets/images/team/hugo.jpg'
      ],
      [
          'name' => 'Vitor Trindade',
          'role' => 'Mentor & Developer',
          'bio' => 'Experienced educator with a background in computer science and networking.',
          'image' => 'assets/images/team/vitor.jpg'
      ]
  ];
  ?>
  
  <!-- Team section: Shows the people behind GetHelp -->
  <section class="team white">
    <div class="container">
      <h2 class="section-title">Our Team</h2>
      <div class="team-grid">
        <?php foreach ($team_members as $member): ?>
          <div class="team-member">
            <img src="<?php echo $member['image']; ?>" alt="<?php echo $member['name']; ?>" onerror="this.src='assets/images/team/default.jpg'">
            <h3><?php echo $member['name']; ?></h3>
            <p class="role"><?php echo $member['role']; ?></p>
            <p class="bio"><?php echo $member['bio']; ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Features section: Highlights the website's features -->
  <section class="features light-gray">
    <div class="container">
      <h2 class="section-title">Platform Features</h2>
      <div class="features-grid">
        <div class="feature-card">
          <h3>🔒 Login System</h3>
          <p>Secure authentication system with password hashing and session management. Access your personalized dashboard and saved tutorials.</p>
        </div>

        <div class="feature-card">
          <h3>📝 Registration</h3>
          <p>Quick and easy registration process with validation for name, email, and phone. Join our community of learners today!</p>
        </div>

        <div class="feature-card">
          <h3>👥 User Management</h3>
          <p>Administrators can manage user roles and permissions. Three distinct roles available:</p>
          <ul class="role-list">
            <li><strong>Student:</strong> Access tutorials and learning materials</li>
            <li><strong>Mentor:</strong> Create and edit tutorials, provide assistance</li>
            <li><strong>Admin:</strong> Full platform management capabilities</li>
          </ul>
        </div>

        <div class="feature-card">
          <h3>🛡️ Role-Based Access</h3>
          <p>Enhanced security with role-based permissions:</p>
          <ul class="permission-list">
            <li>Tutorial creation/editing (Mentors & Admins)</li>
            <li>User management (Admins only)</li>
            <li>Content access control</li>
          </ul>
        </div>

        <div class="feature-card">
          <h3>🤖 CAPTCHA Verification</h3>
          <p>Advanced security system to prevent automated registrations and protect against bots during form submissions.</p>
        </div>

        <div class="feature-card">
          <h3>🍪 Cookie Management</h3>
          <p>GDPR-compliant cookie consent system. Manages user preferences and session data securely.</p>
        </div>
      </div>
    </div>
  </section>

  <script>
    // Ensure cookie consent is checked on this page as well
    document.addEventListener("DOMContentLoaded", checkCookieConsent);
  </script>
</main>

<?php include 'includes/footer.php'; ?>