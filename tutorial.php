<?php 
// ===============================
// tutorial.php - Tutorial Display Page
// ===============================
// This page shows a single tutorial based on the ID in the URL.
// It uses mock data for demonstration. In a real project, you would get this from a database.

// Include configuration file (for settings, database, etc)
require_once 'includes/config.php';

// Get the tutorial ID from the URL (e.g., tutorial.php?id=html-basics)
$tutorial_id = isset($_GET['id']) ? $_GET['id'] : '';

// In a real application, you would fetch the tutorial from a database.
// Here we use a mock array for demonstration purposes.
$tutorial = null;

// List of available tutorials (mock data)
$tutorials = [
    'html-basics' => [
        'title' => 'HTML Basics',
        'category' => 'Web Development',
        'difficulty' => 'Beginner',
        'duration' => '2 hours',
        'author' => 'Hugo Viegas',
        'last_updated' => '19/05/2025',
        'description' => 'Learn the fundamentals of HTML, the building blocks of any website.',
        // The content below is HTML that will be shown in the tutorial body
        'content' => '<h2>Introduction to HTML</h2>
                      <p>HTML (HyperText Markup Language) is the standard markup language for documents designed to be displayed in a web browser. It defines the structure and content of web pages.</p>
                      <h2>HTML Document Structure</h2>
                      <p>An HTML document starts with a document type declaration <code>&lt;!DOCTYPE html&gt;</code> followed by the <code>&lt;html&gt;</code> element, which contains the <code>&lt;head&gt;</code> and <code>&lt;body&gt;</code> elements.</p>
                      <pre><code>&lt;!DOCTYPE html&gt;\n&lt;html&gt;\n&lt;head&gt;\n    &lt;title&gt;Page Title&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n    &lt;h1&gt;My First Heading&lt;/h1&gt;\n    &lt;p&gt;My first paragraph.&lt;/p&gt;\n&lt;/body&gt;\n&lt;/html&gt;</code></pre>
                      <h2>HTML Elements</h2>
                      <p>HTML elements are represented by tags, written using angle brackets. Tags come in pairs like <code>&lt;p&gt;</code> and <code>&lt;/p&gt;</code>, with the content in between.</p>
                      <h3>Common HTML Elements</h3>
                      <ul>
                          <li><code>&lt;h1&gt;</code> to <code>&lt;h6&gt;</code> - Headings</li>
                          <li><code>&lt;p&gt;</code> - Paragraph</li>
                          <li><code>&lt;a&gt;</code> - Link</li>
                          <li><code>&lt;img&gt;</code> - Image</li>
                          <li><code>&lt;ul&gt;</code>, <code>&lt;ol&gt;</code>, <code>&lt;li&gt;</code> - Lists</li>
                          <li><code>&lt;div&gt;</code> - Division or section</li>
                          <li><code>&lt;span&gt;</code> - Inline container</li>
                      </ul>
                      <h2>HTML Attributes</h2>
                      <p>HTML attributes provide additional information about HTML elements. They are always specified in the start tag.</p>
                      <pre><code>&lt;a href="https://www.example.com"&gt;Visit Example.com&lt;/a&gt;</code></pre>
                      <h2>Practice Exercise</h2>
                      <p>Try creating a simple HTML page with a heading, paragraphs, links, and images. Experiment with different HTML elements to understand how they work.</p>'
    ],
    'css-styling' => [
        'title' => 'CSS Styling',
        'category' => 'Web Development',
        'difficulty' => 'Beginner',
        'duration' => '3 hours',
        'author' => 'Vitor Trindade',
        'last_updated' => '19/05/2025',
        'description' => 'Make your websites visually appealing with CSS styling techniques.',
        'content' => '<h2>Introduction to CSS</h2>
                      <p>CSS (Cascading Style Sheets) is used to style and layout web pages. It can be used to alter the font, color, size, and spacing of your content, split it into multiple columns, or add animations and other decorative features.</p>
                      <h2>CSS Syntax</h2>
                      <p>A CSS rule consists of a selector and a declaration block. The selector points to the HTML element you want to style, and the declaration block contains one or more declarations separated by semicolons.</p>
                      <pre><code>selector {\n    property: value;\n    property: value;\n}</code></pre>
                      <h2>Ways to Insert CSS</h2>
                      <ul>
                          <li>External CSS - Using a separate CSS file</li>
                          <li>Internal CSS - Using a <code>&lt;style&gt;</code> element in the HTML <code>&lt;head&gt;</code> section</li>
                          <li>Inline CSS - Using a style attribute in HTML elements</li>
                      </ul>
                      <h2>CSS Selectors</h2>
                      <p>CSS selectors are used to target the HTML elements you want to style.</p>
                      <pre><code>/* Element Selector */\np {\n    color: blue;\n}\n\n/* Class Selector */\n.my-class {\n    font-size: 18px;\n}\n\n/* ID Selector */\n#my-id {\n    background-color: yellow;\n}</code></pre>
                      <h2>Common CSS Properties</h2>
                      <ul>
                          <li><code>color</code> - Text color</li>
                          <li><code>background-color</code> - Background color</li>
                          <li><code>font-family</code> - Font type</li>
                          <li><code>font-size</code> - Font size</li>
                          <li><code>margin</code> - Outer spacing</li>
                          <li><code>padding</code> - Inner spacing</li>
                          <li><code>border</code> - Border around an element</li>
                      </ul>
                      <h2>Practice Exercise</h2>
                      <p>Create a CSS file to style the HTML page you created in the HTML Basics tutorial. Experiment with different CSS properties to see how they affect the appearance of your page.</p>'
    ]
];

// Check if the tutorial exists in our mock data
if (isset($tutorials[$tutorial_id])) {
    $tutorial = $tutorials[$tutorial_id];
} else {
    // If the tutorial does not exist, send the user back to the tutorials list
    header('Location: tutorials.php');
    exit;
}
?>
<?php include 'includes/header.php'; ?>
<main class="tutorial-page">
  <section class="tutorial-header">
    <div class="container">
      <!-- Show the tutorial title and meta info -->
      <h1><?php echo htmlspecialchars($tutorial['title']); ?></h1>
      <div class="meta">
        <span><?php echo htmlspecialchars($tutorial['category']); ?></span>
        <span>Difficulty: <?php echo htmlspecialchars($tutorial['difficulty']); ?></span>
        <span>Duration: <?php echo htmlspecialchars($tutorial['duration']); ?></span>
        <span class="author">By: <?php echo htmlspecialchars($tutorial['author']); ?></span>
        <span>Last Updated: <?php echo htmlspecialchars($tutorial['last_updated']); ?></span>
      </div>
      <p class="description"><?php echo htmlspecialchars($tutorial['description']); ?></p>
    </div>
  </section>
  <section class="tutorial-content">
    <div class="container">
      <div class="tutorial-body">
        <!-- Video Tutorial Section (optional, can be changed per tutorial) -->
        <div class="tutorial-video" style="margin-bottom: 32px; text-align: center;">
          <video width="80%" height="auto" controls poster="assets/images/projects/background-html-css.jpg" style="max-width: 700px; border-radius: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.08);">
            <source src="assets/videos/HTML in 100 Seconds.mp4" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          <div style="margin-top: 10px; color: #555; font-size: 1.05em;">HTML in 100 Seconds (Video Tutorial)</div>
        </div>
        <!-- Main tutorial content (HTML from the mock data) -->
        <?php echo $tutorial['content']; ?>
        <div class="tutorial-resources" id="resources">
          <h2>Additional Resources</h2>
          <ul>
            <li><a href="#" target="_blank">Official Documentation</a></li>
            <li><a href="#" target="_blank">Recommended Books</a></li>
            <li><a href="#" target="_blank">Practice Exercises</a></li>
          </ul>
        </div>
        <div class="tutorial-feedback">
          <h3>Was this tutorial helpful?</h3>
          <div class="rating-buttons">
            <button class="btn small">Yes, it was helpful</button>
            <button class="btn small secondary">No, I still need help</button>
          </div>
          <p>If you need more assistance, <a href="contact-us.php">contact us</a>.</p>
        </div>
      </div>
    </div>
  </section>
  <section class="next-tutorial">
    <div class="container">
      <h2>Ready for More?</h2>
      <p>Continue your learning journey with the next tutorial in this series.</p>
      <a href="tutorial.php?id=css-styling" class="btn primary">Next Tutorial: CSS Styling</a>
    </div>
  </section>
</main>
<?php include 'includes/footer.php'; ?>