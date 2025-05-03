<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Screen Maestro - Simple Digital Signage Manager</title>
  <!-- SEO Meta -->
  <meta name="description" content="Screen Maestro: Lightweight, open-source digital signage manager. Control multiple screens from a single dashboard with simple PHP + MySQL setup." />
  <meta name="keywords" content="digital signage, open-source signage, screen manager, PHP signage, MySQL signage" />
  <link rel="canonical" href="https://screenmaestro.com/" />
  <!-- Open Graph / Facebook -->
  <meta property="og:title" content="Screen Maestro - Simple Digital Signage Manager" />
  <meta property="og:description" content="The lightweight, open-source digital signage solution to control screens from one dashboard. No bloat, no fees." />
  <meta property="og:image" content="https://screenmaestro.com/assets/branding/hdr.png" />
  <meta property="og:url" content="https://screenmaestro.com/" />
  <meta property="og:type" content="website" />
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Screen Maestro - Simple Digital Signage Manager" />
  <meta name="twitter:description" content="The lightweight, open-source digital signage solution to control screens from one dashboard. No bloat, no fees." />
  <meta name="twitter:image" content="https://screenmaestro.com/assets/branding/hdr.png" />
  <style>
    body {
      margin: 0;
      font-family: 'Arial', sans-serif;
      background: #f5f5f5;
      color: #333;
    }
    header {
      background: url('https://screenmaestro.com/assets/branding/hdr.png') center center / cover no-repeat;
      color: white;
      text-align: center;
      padding: 100px 20px;
      position: relative;
    }
    header::after {
      content: '';
      position: absolute;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 0;
    }
    header > * {
      position: relative;
      z-index: 1;
    }
    .header-logo {
      max-width: 220px;
      height: auto;
      margin-bottom: 30px;
    }

    .button-group {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 30px 0;
      flex-wrap: wrap;
      padding: 0 20px;
    }
    .download-button,
    .github-button,
    .donate-button,
    .help-button {
      padding: 15px 30px;
      font-size: 18px;
      border-radius: 6px;
      font-weight: bold;
      text-decoration: none;
      color: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      transition: background 0.3s ease;
    }
    .download-button {
      background-color: #28a745;
    }
    .download-button:hover {
      background-color: #218838;
    }
    .github-button {
      background-color: #24292e;
    }
    .github-button:hover {
      background-color: #111;
    }
    .donate-button {
      background-color: #ffc107;
      color: #333;
    }
    .donate-button:hover {
      background-color: #e0a800;
    }
    .help-button {
      background-color: #17a2b8;
    }
    .help-button:hover {
      background-color: #117a8b;
    }

    section {
      padding: 60px 20px;
      max-width: 1000px;
      margin: auto;
    }
    section h2 {
      font-size: 36px;
      margin-bottom: 20px;
    }
    section ul {
      list-style: none;
      padding: 0;
    }
    section ul li {
      margin-bottom: 15px;
      font-size: 20px;
      padding-left: 25px;
      position: relative;
    }
    section ul li::before {
      content: "✔️";
      position: absolute;
      left: 0;
    }

    .login-info {
      font-size: 18px;
      margin-top: 20px;
      background: #e9ecef;
      padding: 10px 20px;
      border-radius: 5px;
    }
    .about, .donate {
      background: #ffffff;
      padding: 40px 20px;
      margin-top: 40px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    }
    .donate a {
      display: inline-block;
      margin-top: 20px;
      background: #28a745;
      color: white;
      padding: 15px 30px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 18px;
    }

    /* Help section styles */
    section.help h2 {
      margin-top: 0;
    }
    section.help pre {
      background: #222;
      color: #0f0;
      padding: 1rem;
      overflow-x: auto;
      border-radius: 5px;
    }
    section.help ol,
    section.help ul {
      margin-left: 1.2rem;
      margin-bottom: 1.5rem;
    }
    section.help h3 {
      margin-top: 1.5rem;
    }

    footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      background: #eee;
      margin-top: 60px;
    }
  </style>
</head>
<body>

  <header>
    <img src="https://screenmaestro.com/assets/branding/logo.png" alt="ScreenMaestro Logo" class="header-logo">
    <h1>Screen Maestro</h1>
    <p>Your simple, reliable digital signage manager</p>
  </header>

  <div class="button-group">
    <a href="https://screenmaestro.com/downloads/screenmaestroV1.0.zip" class="download-button">⬇️ Download Now</a>
    <a href="https://github.com/Frizbys/Screen-Maestro" class="github-button" target="_blank">💻 View on GitHub</a>
    <a href="#help" class="help-button">📖 Help & Docs</a>
    <a href="https://cash.app/$payfrizbys" class="donate-button" target="_blank">💸 Donate</a>
  </div>

  <section id="features">
    <h2>Why Choose Screen Maestro?</h2>
    <ul>
      <li>Manage multiple screens from a single dashboard</li>
      <li>Upload and assign images or videos effortlessly</li>
      <li>Runs beautifully on mini-PCs, kiosks, TVs, and more</li>
      <li>No bloated software, no surprise hosting fees</li>
      <li>Mobile & desktop friendly interface</li>
      <li>Battle-tested in real environments</li>
      <li>100% open-source — you own it, you control it</li>
      <li>Simple PHP + MySQL setup — no heavy frameworks</li>
    </ul>
    <div class="login-info">
      <strong>Default Login:</strong><br>
      Username: <code>admin</code><br>
      Password: <code>Ecliptic$Commander2025!</code>
    </div>
  </section>

  <section class="about">
    <h2>About Screen Maestro</h2>
    <p>Screen Maestro was born out of frustration with overpriced, over-engineered signage services. Now it powers real stores—syncing catalogs and promotions across screens 24/7 without breaking the bank.</p>
    <p>Released for FREE to help small businesses, makers, hackers, and entrepreneurs who deserve better.</p>
  </section>

  <section class="donate">
    <h2>Support Screen Maestro</h2>
    <p>If Screen Maestro saves you time or money, consider a tip to fuel future improvements!</p>
    <a href="https://cash.app/$payfrizbys" target="_blank">💸 Donate via Cash App</a>
  </section>

  <section id="help" class="help">
    <h2>Help & Documentation</h2>

    <h3>1. Installation</h3>
    <ol>
      <li>Unpack the archive into your web root.</li>
      <li>Import <code>database.sql</code> into your MySQL server (it includes the schema and sample data).</li>
      <li>Copy <code>config_example.php</code> to <code>config.php</code> and update with your DB credentials.</li>
      <li>Run the built-in installer by visiting <code>/install.php</code>, or skip straight to manual setup if you prefer.</li>
    </ol>

    <h3>2. Default Credentials</h3>
    <pre>
Username: admin
Password: Ecliptic$Commander2025!
    </pre>

    <h3>3. Managing Screens</h3>
    <ul>
      <li><strong>Add Screen:</strong> Give it an ID and optional share token.</li>
      <li><strong>Edit Screen:</strong> Upload images/videos or add HTML blocks.</li>
      <li><strong>Delete Screen:</strong> Remove it from rotation.</li>
    </ul>

    <h3>4. Uploading Content</h3>
    <ol>
      <li>Select your screen in the dashboard.</li>
      <li>Click “Upload” and choose your image or video files.</li>
      <li>Set order & duration, then hit “Save.”</li>
    </ol>

    <h3>5. Troubleshooting</h3>
    <ul>
      <li><strong>Blank/Black Screen:</strong> Check file permissions in <code>/uploads/</code>.</li>
      <li><strong>500 Errors:</strong> Ensure you’re on PHP 7.4+ with PDO and GD extensions enabled.</li>
      <li><strong>QR Codes Missing:</strong> Confirm GD library is installed and your links are valid.</li>
    </ul>

    <h3>6. FAQs</h3>
    <p><strong>Q:</strong> Can I run in a sub-folder?<br>
       <strong>A:</strong> Yes—just adjust your <code>$basePath</code> in <code>config.php</code> and update your vhost.</p>

    <h3>7. Need More Help?</h3>
    <p>Visit <a href="https://github.com/Frizbys/Screen-Maestro/issues" target="_blank">GitHub Issues</a> or email <code>support@screenmaestro.com</code>.</p>
  </section>

  <footer>
    &copy; 2025 Screen Maestro. Built by Real People for Real Businesses.
  </footer>

</body>
</html>
