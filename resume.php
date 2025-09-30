<?php
session_start();

// Protect page
if (empty($_SESSION['auth'])) {
  header('Location: login.php');
  exit;
}

// Handle logout
if (isset($_GET['logout'])) {
  $_SESSION = [];
  session_destroy();
  session_start();
  $_SESSION['flash'] = ['type' => 'success', 'text' => 'Logged out successfully.'];
  header('Location: login.php');
  exit;
}

// Resume data
$name      = 'RALPH VINCENT A. CAMBA';
$title     = 'Computer Science Student • Workflow Automation Enthusiast';
$phone     = '09192484436';
$email     = 'rvcamba57@gmail.com';
$location  = 'Mamatid, Cabuyao, Laguna';
$summary   = 'Detail-oriented Computer Science student with hands-on experience in workflow automation using Make.com. Proficient in programming with C++, Java, Python, and C#, with solid experience in MySQL. Passionate about building efficient systems through both automation and custom software solutions.';

$skills = [
  'Programming Languages: C++, Python, Java, C#',
  'Workflow Automation (Make.com)',
  'Version Control: Git',
  'MySQL (backend & data management)',
  'Microsoft Office',
  'Graphic Design (Canva)'
];

$core_competencies = [
  'Adaptability & Continuous Learning',
  'Problem Solving',
  'Analytical Thinking'
];

$education = [
  ['school' => 'Batangas State University', 'program' => 'BS Computer Science', 'dates' => '2023 – Present', 'notes' => '3rd Year College Student'],
  ['school' => 'Pamantasan ng Cabuyao', 'program' => 'Senior High School – STEM', 'dates' => 'Graduated July 2023', 'notes' => ''],
  ['school' => 'Pulo National High School', 'program' => 'Junior High School', 'dates' => 'Completed July 2021', 'notes' => ''],
  ['school' => 'San Isidro Elementary School', 'program' => 'Elementary', 'dates' => 'Completed April 2017', 'notes' => ''],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?= htmlspecialchars($name) ?> – Resume</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #121212;
      font-family: system-ui, Arial, sans-serif;
      color: #e5e5e5;
      line-height: 1.55;
    }

    .card {
      border: 1px solid #2d2d2d;
      border-radius: 12px;
      padding: 24px;
      background: #1e1e1e;
      width: 100%;
      max-width: 760px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.6);
      overflow-y: auto;
      max-height: 90vh;
    }

    h1 { margin: 0 0 6px; font-size: 28px; color: #ffffff; }
    .subtitle { margin: 0 0 16px; color: #9ca3af; }
    .chips { display: flex; flex-wrap: wrap; gap: 8px 12px; margin-bottom: 20px; }
    .chip {
      border: 1px solid #2d2d2d;
      border-radius: 999px;
      padding: 6px 12px;
      font-size: 12px;
      background: #2b2b2b;
      color: #e5e5e5;
      text-decoration: none;
    }

    .chip:hover { background: #374151; }
    .section {
      border: 1px solid #2d2d2d;
      border-radius: 10px;
      padding: 14px;
      margin-top: 14px;
      background: #1e1e1e;
    }

    .section h3 {
      margin: 0 0 8px;
      font-size: 13px;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #9ca3af;
    }

    .list { 
      list-style: none; 
      padding-left: 0; 
      margin: 0; 
    }

    .list li { 
      margin: 6px 0; 
      padding-left: 14px; 
      position: relative; 
    }

    .list li::before { 
      content:"•"; 
      position:absolute; 
      left:0; color:#9ca3af; 
    }

    .edu-item { 
      border-left: 3px solid #2d2d2d; 
      padding-left: 10px; 
      margin: 10px 0; 
    }

    .edu-title { font-weight: 700; }
    .edu-sub { 
      color: #9ca3af; 
      font-size: 13px; 
    }

    .actions { 
      margin-top: 20px; 
      display: flex; 
      gap: 12px; 
    }
    .actions a, .actions button {
      padding: 8px 12px; 
      border-radius: 6px; 
      font-size: 13px;
      border: none; cursor: pointer;
      background: #4f46e5; color: #fff; text-decoration: none;
    }
    .actions a:hover, .actions button:hover { background: #4338ca; }
    .site-footer { margin-top: 20px; text-align: center; font-size: 12px; color: #9ca3af; }
  </style>
</head>
<body>
  <div class="card">
    <h1><?= htmlspecialchars($name) ?></h1>
    <p class="subtitle"><?= htmlspecialchars($title) ?></p>

    <div class="chips">
      <span class="chip">📍 <?= htmlspecialchars($location) ?></span>
      <a class="chip" href="tel:<?= htmlspecialchars($phone) ?>">📞 <?= htmlspecialchars($phone) ?></a>
      <a class="chip" href="mailto:<?= htmlspecialchars($email) ?>">✉️ <?= htmlspecialchars($email) ?></a>
    </div>

    <section class="section">
      <h3>Summary</h3>
      <p><?= htmlspecialchars($summary) ?></p>
    </section>

    <section class="section">
      <h3>Skills</h3>
      <ul class="list">
        <?php foreach($skills as $s): ?>
          <li><?= htmlspecialchars($s) ?></li>
        <?php endforeach; ?>
      </ul>
    </section>

    <section class="section">
      <h3>Core Competencies</h3>
      <ul class="list">
        <?php foreach($core_competencies as $c): ?>
          <li><?= htmlspecialchars($c) ?></li>
        <?php endforeach; ?>
      </ul>
    </section>

    <section class="section">
      <h3>Education</h3>
      <?php foreach($education as $e): ?>
        <div class="edu-item">
          <div class="edu-title"><?= htmlspecialchars($e['school']) ?></div>
          <div><?= htmlspecialchars($e['program']) ?></div>
          <div class="edu-sub"><?= htmlspecialchars($e['dates']) ?><?= $e['notes'] !== '' ? ' • '.htmlspecialchars($e['notes']) : '' ?></div>
        </div>
      <?php endforeach; ?>
    </section>

    <div class="actions">
      <a href="?logout=1">🚪 Logout</a>
      <button onclick="window.print()">🖨️ Download PDF</button>
    </div>

    <div class="site-footer">
      © <?= date('Y') ?> <?= htmlspecialchars($name) ?>. Dark Theme Resume Website.
    </div>
  </div>
</body>
</html>
