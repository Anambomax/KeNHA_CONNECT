<?php
session_start();
require_once '../api/config.php';

if (!isset($_SESSION['email'])) {
  header("Location: ../index.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_SESSION['email'];
  $description = trim($_POST['description']);
  $feedback_category = $_POST['feedback_category'];
  $feedback_subcategory = '';
  $details = null;
  $photo = null;

  // Determine correct subcategory
  if ($feedback_category === 'incident') {
    $feedback_subcategory = $_POST['feedback_subcategory_incident'] ?? '';
    if ($feedback_subcategory === 'accident') {
      $details = $_POST['details'] ?? null;
    }
  } elseif ($feedback_category === 'general feedback') {
    $feedback_subcategory = $_POST['feedback_subcategory_general'] ?? '';
  }

  // Get user info
  try {
    $stmt = $conn->prepare("SELECT id, full_name, county FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      $_SESSION['flash'] = "User not found.";
      header("Location: ../dashboard.php#feed");
      exit();
    }

    $user_id = $user['id'];
    $user_name = $user['full_name'];
    $location = $user['county'];
  } catch (PDOException $e) {
    die("Error: " . $e->getMessage());
  }

  // Handle image upload
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['photo']['tmp_name'];
    $fileName = time() . '_' . basename($_FILES['photo']['name']);
    $targetPath = "../public/uploads/" . $fileName;

    if (move_uploaded_file($fileTmp, $targetPath)) {
      $photo = $fileName;
    }
  }

  // Insert feedback
  try {
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, user_name, description, feedback_category, feedback_subcategory, details, photo, location, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$user_id, $user_name, $description, $feedback_category, $feedback_subcategory, $details, $photo, $location]);

    $_SESSION['flash'] = "✅ Feedback submitted successfully!";
    header("Location: ../dashboard.php#feed");
    exit();
  } catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Feedback - KeNHA Connect</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }
    .feedback-form-container {
      max-width: 650px;
      margin: auto;
      background: white;
      padding: 35px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 25px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    select, textarea, input[type="file"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }
    .btn-submit {
      background-color: #003366;
      color: white;
      border: none;
      padding: 12px 20px;
      margin-top: 25px;
      cursor: pointer;
      width: 100%;
      border-radius: 6px;
      font-size: 16px;
    }
    .btn-submit:hover {
      background-color: #002244;
    }
    .back-link {
      display: block;
      text-align: center;
      margin-top: 25px;
      color: #003366;
      text-decoration: none;
    }
    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="feedback-form-container">
    <h2>📢 Submit Feedback</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <label for="photo">Upload Photo (optional)</label>
      <input type="file" name="photo" accept="image/*">

      <label for="description">Describe the feedback</label>
      <textarea name="description" rows="4" placeholder="Describe what happened..." required></textarea>

      <label for="feedback_category">What best matches your feedback?</label>
      <select name="feedback_category" id="feedback_category" required onchange="toggleSubcategories()">
        <option value="">-- Select Category --</option>
        <option value="incident">Incident</option>
        <option value="general feedback">General Feedback</option>
      </select>

      <div id="incident_sub" style="display:none;">
        <label for="feedback_subcategory_incident">Select type of incident</label>
        <select name="feedback_subcategory_incident" onchange="toggleDetails()">
          <option value="">-- Select Subcategory --</option>
          <option value="accident">Accident</option>
          <option value="complaint">Complaint</option>
          <option value="request">Request</option>
        </select>

        <div id="accident_details" style="display:none;">
          <label for="details">Accident Type</label>
          <select name="details">
            <option value="">-- Select Details --</option>
            <option value="fatal">Fatal</option>
            <option value="not fatal">Not Fatal</option>
          </select>
        </div>
      </div>

      <div id="general_sub" style="display:none;">
        <label for="feedback_subcategory_general">Select feedback type</label>
        <select name="feedback_subcategory_general">
          <option value="">-- Select Subcategory --</option>
          <option value="compliment">Compliment</option>
          <option value="critic">Critic</option>
        </select>
      </div>

      <button class="btn-submit" type="submit">Submit Feedback</button>
    </form>

    <a class="back-link" href="../dashboard.php">← Back to Dashboard</a>
  </div>

  <script>
    function toggleSubcategories() {
      const category = document.getElementById('feedback_category').value;
      document.getElementById('incident_sub').style.display = (category === 'incident') ? 'block' : 'none';
      document.getElementById('general_sub').style.display = (category === 'general feedback') ? 'block' : 'none';
    }

    function toggleDetails() {
      const sub = document.querySelector('select[name="feedback_subcategory_incident"]').value;
      document.getElementById('accident_details').style.display = (sub === 'accident') ? 'block' : 'none';
    }
  </script>
</body>
</html>
