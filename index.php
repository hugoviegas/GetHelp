<?php 
// ===============================
// index.php - Home Page
// ===============================
// This is the main landing page for the GetHelp platform.
// It introduces the project, features, testimonials, and main tutorial categories.

// Include configuration file (for settings, database, etc)
require_once 'includes/config.php';
?>
<?php include 'includes/header.php'; ?>

<main>
  <!-- Introduction section: Welcomes the user and explains the purpose of the site -->
  <section class="intro light-gray">
    <div class="container">
      <h1>Welcome to GetHelp</h1>
      <p class="subtitle">
        Your ultimate companion for mastering college modules.
      </p>
      <p class="description">
        Struggling with Web Development, Java, Maths or any other
        college subjects? <br>
        We've got you covered with tutorials, guides and
        personalized help.
      </p>
      <div class="cta-buttons">
        <!-- Buttons to quickly access tutorials or request help -->
        <a href="tutorials.php" class="btn primary" aria-label="Explore Tutorials">Explore Tutorials</a>
        <a href="contact-us.php" class="btn secondary" aria-label="Request Help">Request Help</a>
      </div>
    </div>
  </section>

  <!-- Features section: Highlights what makes GetHelp useful for students -->
  <section class="features white">
    <div class="container">
      <h2 class="section-title">Why do you need to GetHelp</h2>
      <div class="features-grid">
        <div class="feature-item">
          <div class="feature-icon">📚</div>
          <h3>Personalized Tutorials</h3>
          <p>
            Access resources and tutorials of your college modules and subjects according to your needs.
          </p>
        </div>
        <div class="feature-item">
          <div class="feature-icon">🤝</div>
          <h3>Expert Guidance</h3>
          <p>
            Request help from experienced tutors who understand your
            challenges.
          </p>
        </div>
        <div class="feature-item">
          <div class="feature-icon">💡</div>
          <h3>Project Showcase</h3>
          <p>
            Learn from real-world examples, including how this very website
            was built!
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Users feedbacks Section: Shows testimonials from students -->
  <section class="feedbacks light-gray">
    <div class="container">
      <h2 class="section-title">What our users say</h2>
      <div class="feedbacks-slider">
        <?php
        // Array of testimonials (could be loaded from a database)
        $testimonials = [
          [
            'quote' => 'GetHelp saved my semester! The tutorials on JavaScript validation were exactly what I needed.',
            'author' => 'Carlos Eduardo, Web Development Module'
          ],
          [
            'quote' => 'I was struggling with my Java project and GetHelp provided me with the guidance I needed to succeed.',
            'author' => 'Victor Trindade, H-Dip Science of Computing Student'
          ]
        ];
        // Loop through testimonials and display each one
        foreach ($testimonials as $testimonial) {
          echo '<div class="feedback">';
          echo '<p class="quote">"' . $testimonial['quote'] . '"</p>';
          echo '<p class="author">- ' . $testimonial['author'] . '</p>';
          echo '</div>';
        }
        ?>
      </div>  
    </div>
  </section>

  <!-- Tutorials Section: Shows main categories for quick access -->
  <section class="tutorials white">
    <div class="container">
      <h2 class="section-title">Explore Our Tutorials</h2>
      <div class="categories-grid">
        <!-- Each card represents a main tutorial category -->
        <div class="category-card">
          <img src="assets/images/webdev.svg" alt="Web Development">
          <h3>Web Development</h3>
          <p>Learn how to create modern, responsive websites using HTML, CSS, JavaScript, and PHP.</p>
          <a href="tutorials.php?category=web-dev" class="btn small">Explore Tutorials</a>
        </div>
        <div class="category-card">
          <img src="assets/images/software_fund.svg" alt="Software Fundamentals">
          <h3>Software Fundamentals</h3>
          <p>Master the core concepts of software development, algorithms, and programming logic.</p>
          <a href="tutorials.php?category=software-fundamentals" class="btn small">Explore Tutorials</a>
        </div>
        <div class="category-card">
          <img src="assets/images/projectskills.svg" alt="Project Skills">
          <h3>Project Skills</h3>
          <p>Develop skills to manage projects effectively, work in teams, and deliver successful outcomes.</p>
          <a href="tutorials.php?category=project-skills" class="btn small">Explore Tutorials</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Call to Action Section: Encourages students to register -->
  <section class="cta-section blue-bg">
    <div class="container">
      <h2>Ready to Boost Your Learning?</h2>
      <p>
        Join thousands of students who are mastering their college modules
        with GetHelp.
      </p>
      <a href="register.php" class="btn primary large" aria-label="Get Started Today">Get Started Today</a>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>