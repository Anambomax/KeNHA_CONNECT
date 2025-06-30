<?php
require_once '../api/session.php';
$user_name = $_SESSION['user_name'];
$location = $_SESSION['location'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Submit Feedback - KeNHA Connect</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="kenha-bg">
  <div class="main-content">
    <h2>Submit Feedback</h2>
    <form action="../api/submit_feedback_backend.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="user_name" value="<?= htmlspecialchars($user_name) ?>">
      <input type="hidden" name="location" value="<?= htmlspecialchars($location) ?>">

      <label for="photo">Upload Photo:</label>
      <input type="file" name="photo" accept="image/*">

      <label for="description">Describe the feedback:</label>
      <textarea name="description" rows="4" required></textarea>

      <label for="feedback_category">What best matches your feedback?</label>
      <select name="feedback_category" id="feedback_category" required onchange="handleCategory(this.value)">
        <option value="">Select category</option>
        <option value="incident">Incident</option>
        <option value="general feedback">General Feedback</option>
      </select>

      <div id="subcategory-group" style="display:none;">
        <label for="feedback_subcategory">Choose a subcategory:</label>
        <select name="feedback_subcategory" id="feedback_subcategory" required onchange="handleSubCategory(this.value)">
          <!-- dynamically populated via JS -->
        </select>
      </div>

      <div id="details-group" style="display:none;">
        <label for="details">Details (only for 'Accident'):</label>
        <select name="details" id="details">
          <option value="fatal">Fatal</option>
          <option value="not fatal">Not Fatal</option>
        </select>
      </div>

      <button class="btn" type="submit">Submit Feedback</button>
    </form>
  </div>

  <script>
    function handleCategory(value) {
      const subCat = document.getElementById('feedback_subcategory');
      const group = document.getElementById('subcategory-group');
      const details = document.getElementById('details-group');

      subCat.innerHTML = ''; // Reset

      if (value === 'incident') {
        subCat.innerHTML += '<option value="accident">Accident</option>';
        subCat.innerHTML += '<option value="complaint">Complaint</option>';
        subCat.innerHTML += '<option value="request">Request</option>';
        group.style.display = 'block';
      } else if (value === 'general feedback') {
        subCat.innerHTML += '<option value="compliment">Compliment</option>';
        subCat.innerHTML += '<option value="critic">Critic</option>';
        group.style.display = 'block';
        details.style.display = 'none';
      } else {
        group.style.display = 'none';
        details.style.display = 'none';
      }
    }

    function handleSubCategory(value) {
      const details = document.getElementById('details-group');
      details.style.display = (value === 'accident') ? 'block' : 'none';
    }
  </script>
</body>
</html>
