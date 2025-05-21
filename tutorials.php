<?php
// ===============================
// tutorials.php - Tutorials Listing Page
// ===============================
// This page lists all tutorials, allows filtering, and lets mentors/admins add or edit tutorials.
// Students must be logged in to view tutorials.
// Include configuration file and start session if needed
require_once 'includes/config.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Check if the user is logged in (students must log in to view tutorials)
if (!isset($_SESSION['user_id'])) {
  include 'includes/header.php';
  echo '<main><section class="intro"><div class="container" style="text-align:center; padding:120px 0 100px;">';
  echo '<h1>Sorry...</h1>';
  echo '<p class="subtitle">You must be signed in to view tutorials.</p>';
  echo '<div style="margin:30px;">';
  echo '<a href="login.php" class="btn primary" style="margin:10px;">Login</a>';
  echo '<a href="register.php" class="btn secondary" style="margin:10px;">Register</a>';
  echo '</div>';
  echo '</div></section></main>';
  include 'includes/footer.php';
  exit;
}

// Define tutorials data - in a real application this would likely come from a database
$tutorials_categories = [
    'web-dev' => [
        'name' => 'Web Development',
        'description' => 'Learn how to create modern, responsive websites using HTML, CSS, JavaScript, and PHP.',
        'icon' => 'assets/images/webdev.svg',
        'tutorials' => [
            [
                'id' => 'html-basics',
                'title' => 'HTML Basics',
                'description' => 'Learn the fundamentals of HTML, the building blocks of any website.',
                'difficulty' => 'Beginner',
                'duration' => '2 hours'
            ],
            [
                'id' => 'css-styling',
                'title' => 'CSS Styling',
                'description' => 'Make your websites visually appealing with CSS styling techniques.',
                'difficulty' => 'Beginner',
                'duration' => '3 hours'
            ],
            [
                'id' => 'javascript-interactivity',
                'title' => 'JavaScript Interactivity',
                'description' => 'Add interactivity to your websites with JavaScript.',
                'difficulty' => 'Intermediate',
                'duration' => '4 hours'
            ],
            [
                'id' => 'php-basics',
                'title' => 'PHP Basics',
                'description' => 'Get started with PHP, a server-side scripting language.',
                'difficulty' => 'Intermediate',
                'duration' => '5 hours'
            ]
        ]
    ],
    'software-fundamentals' => [
        'name' => 'Software Fundamentals',
        'description' => 'Master the core concepts of software development, algorithms, and programming logic.',
        'icon' => 'assets/images/software_fund.svg',
        'tutorials' => [
            [
                'id' => 'programming-logic',
                'title' => 'Programming Logic',
                'description' => 'Understand the fundamental logic behind programming.',
                'difficulty' => 'Beginner',
                'duration' => '3 hours'
            ],
            [
                'id' => 'data-structures',
                'title' => 'Data Structures',
                'description' => 'Learn about various data structures and their applications.',
                'difficulty' => 'Intermediate',
                'duration' => '6 hours'
            ],
            [
                'id' => 'algorithms',
                'title' => 'Algorithms',
                'description' => 'Explore common algorithms and their implementations.',
                'difficulty' => 'Advanced',
                'duration' => '8 hours'
            ]
        ]
    ],
    'project-skills' => [
        'name' => 'Project Skills',
        'description' => 'Develop skills to manage projects effectively, work in teams, and deliver successful outcomes.',
        'icon' => 'assets/images/projectskills.svg',
        'tutorials' => [
            [
                'id' => 'project-management',
                'title' => 'Project Management',
                'description' => 'Learn the basics of project management and how to plan and execute projects.',
                'difficulty' => 'Beginner',
                'duration' => '4 hours'
            ],
            [
                'id' => 'team-collaboration',
                'title' => 'Team Collaboration',
                'description' => 'Develop skills to work effectively in a team environment.',
                'difficulty' => 'Intermediate',
                'duration' => '3 hours'
            ],
            [
                'id' => 'git-version-control',
                'title' => 'Git Version Control',
                'description' => 'Master Git for version control and collaboration in software projects.',
                'difficulty' => 'Intermediate',
                'duration' => '5 hours'
            ]
        ]
    ]
];

// Check if we're viewing a specific category
$current_category = isset($_GET['category']) ? $_GET['category'] : null;

// Check if user is a mentor or admin
$is_mentor = isset($_SESSION['user']) && isset($_SESSION['user']['role']) && ($_SESSION['user']['role'] === 'mentor' || $_SESSION['user']['role'] === 'admin');
?>
<?php include 'includes/header.php'; ?>

<main>
  <section class="intro">
    <div class="container">
      <h1>Tutorials</h1>
      <p class="subtitle">Learn at your own pace</p>
      <p class="description">
        Explore our comprehensive collection of tutorials covering a wide range
        of college modules. Whether you're struggling with Web Development,
        Software Fundamentals, or Project Skills, we've got you covered.
      </p>
    </div>
  </section>

  <!-- Search and Filter Section -->
  <section class="search-filter">
    <div class="container">
      <div class="search-box">
        <input type="text" id="tutorial-search" placeholder="Search tutorials..." />
        <button id="search-btn">Search</button>
      </div>
      <div class="filters">
        <select id="difficulty-filter">
          <option value="">All Difficulties</option>
          <option value="Beginner">Beginner</option>
          <option value="Intermediate">Intermediate</option>
          <option value="Advanced">Advanced</option>
        </select>
        <select id="duration-filter">
          <option value="">All Durations</option>
          <option value="short">Short (< 3 hours)</option>
          <option value="medium">Medium (3-6 hours)</option>
          <option value="long">Long (> 6 hours)</option>
        </select>
      </div>
    </div>
  </section>

  <!-- Categories and Tutorials -->
  <section class="tutorial-content">
    <div class="container">
      <?php if ($current_category && isset($tutorials_categories[$current_category])): ?>
        <!-- Single Category View -->
        <?php $category = $tutorials_categories[$current_category]; ?>
        <div class="category-header">
          <img src="<?php echo $category['icon']; ?>" alt="<?php echo $category['name']; ?>" onerror="this.src='assets/images/default-category.svg'">
          <h2><?php echo $category['name']; ?></h2>
          <p><?php echo $category['description']; ?></p>
          <a href="tutorials.php" class="btn small">Back to All Categories</a>
          <?php if ($is_mentor): ?>
            <a href="add_tutorial.php?category=<?php echo $current_category; ?>" class="btn primary" style="margin-left:10px;">Add Tutorial</a>
          <?php endif; ?>
        </div>
        
        <div class="tutorials-list">
          <?php foreach ($category['tutorials'] as $tutorial): ?>
            <div class="tutorial-card" id="<?php echo $tutorial['id']; ?>">
              <h3><?php echo $tutorial['title']; ?></h3>
              <p class="description"><?php echo $tutorial['description']; ?></p>
              <div class="tutorial-meta">
                <span class="difficulty">Difficulty: <?php echo $tutorial['difficulty']; ?></span>
                <span class="duration">Duration: <?php echo $tutorial['duration']; ?></span>
              </div>
              <a href="tutorial.php?id=<?php echo $tutorial['id']; ?>" class="btn small">View Tutorial</a>
              <?php if ($is_mentor): ?>
                <a href="edit_tutorial.php?category=<?php echo $current_category; ?>&id=<?php echo $tutorial['id']; ?>" class="btn small secondary" style="margin-left:8px;">Edit</a>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <!-- All Categories View -->
        <h2 class="section-title">Tutorial Categories</h2>
        <div class="categories-grid">
          <?php foreach ($tutorials_categories as $category_id => $category): ?>
            <div class="category-card" id="<?php echo $category_id; ?>">
              <img src="<?php echo $category['icon']; ?>" alt="<?php echo $category['name']; ?>" onerror="this.src='assets/images/default-category.svg'">
              <h3><?php echo $category['name']; ?></h3>
              <p><?php echo $category['description']; ?></p>
              <p class="tutorial-count"><?php echo count($category['tutorials']); ?> tutorials available</p>
              <a href="tutorials.php?category=<?php echo $category_id; ?>" class="btn small">Explore Tutorials</a>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Request Tutorial Section -->
  <section class="request-tutorial">
    <div class="container">
      <h2>Can't Find What You Need?</h2>
      <p>
        If you're looking for a specific tutorial that we don't have yet, let us
        know and we'll consider creating it for you.
      </p>
      <a href="contact-us.php" class="btn primary">Request a Tutorial</a>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>

<script>
  // Client-side filtering functionality
  document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('tutorial-search');
    const difficultyFilter = document.getElementById('difficulty-filter');
    const durationFilter = document.getElementById('duration-filter');
    const searchBtn = document.getElementById('search-btn');
    const tutorialsList = document.querySelector('.tutorials-list');
    const tutorialCards = tutorialsList ? Array.from(tutorialsList.getElementsByClassName('tutorial-card')) : [];

    function durationToCategory(durationStr) {
      // Extract number of hours from string like '3 hours'
      const match = durationStr.match(/(\d+)/);
      if (!match) return '';
      const hours = parseInt(match[1], 10);
      if (hours < 3) return 'short';
      if (hours <= 6) return 'medium';
      return 'long';
    }

    function filterTutorials() {
      const searchText = searchInput.value.trim().toLowerCase();
      const difficulty = difficultyFilter.value;
      const duration = durationFilter.value;
      let anyVisible = false;
      tutorialCards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        const desc = card.querySelector('.description').textContent.toLowerCase();
        const meta = card.querySelector('.tutorial-meta');
        const diffText = meta ? meta.querySelector('.difficulty').textContent : '';
        const durText = meta ? meta.querySelector('.duration').textContent : '';
        let matches = true;
        if (searchText && !(title.includes(searchText) || desc.includes(searchText))) {
          matches = false;
        }
        if (difficulty && (!diffText.includes(difficulty))) {
          matches = false;
        }
        if (duration) {
          const durCat = durationToCategory(durText);
          if (durCat !== duration) matches = false;
        }
        card.style.display = matches ? '' : 'none';
        if (matches) anyVisible = true;
      });
      // Show a message if no tutorials match
      let noResults = document.getElementById('no-tutorials-found');
      if (!anyVisible && tutorialsList) {
        if (!noResults) {
          noResults = document.createElement('div');
          noResults.id = 'no-tutorials-found';
          noResults.textContent = 'No tutorials found matching your criteria.';
          noResults.style.textAlign = 'center';
          noResults.style.color = '#888';
          noResults.style.margin = '40px 0';
          tutorialsList.appendChild(noResults);
        }
      } else if (noResults) {
        noResults.remove();
      }
    }

    if (tutorialCards.length) {
      searchInput.addEventListener('input', filterTutorials);
      difficultyFilter.addEventListener('change', filterTutorials);
      durationFilter.addEventListener('change', filterTutorials);
      searchBtn.addEventListener('click', function(e) {
        e.preventDefault();
        filterTutorials();
      });
    }
  });
</script>

<style>
  /* Add spacing at the bottom of the tutorials categories section */
  .tutorial-content {
    margin-bottom: 40px;
  }
</style>