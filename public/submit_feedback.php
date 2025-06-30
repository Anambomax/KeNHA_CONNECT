<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Feedback - KeNHA Connect</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    .feedback-form-container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .feedback-form-container h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 20px;
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
      margin-top: 20px;
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
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="feedback-form-container">
    <h2>📢 Submit Feedback</h2>
    <form action="../api/submit_feedback.php" method="POST" enctype="multipart/form-data">
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
        <label for="feedback_subcategory">Select type of incident</label>
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

    <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
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
