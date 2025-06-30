<!-- kenha-connect/public/post.php -->
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
  <title>Create Post - KeNHA Connect</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    .form-box {
      max-width: 600px;
      margin: 40px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    label, select, textarea, input[type=\"file\"] {
      display: block;
      width: 100%;
      margin-bottom: 15px;
    }

    textarea {
      height: 120px;
      resize: vertical;
    }

    .hidden { display: none; }

    button {
      background-color: #012c57;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }

    button:hover {
      background-color: #03457e;
    }
  </style>
  <script>
    function toggleCategory() {
      const type = document.getElementById('type').value;
      document.getElementById('incident-options').style.display = (type === 'incident') ? 'block' : 'none';
      document.getElementById('feedback-options').style.display = (type === 'feedback') ? 'block' : 'none';
    }
  </script>
</head>
<body>
  <div class="form-box">
    <h2>Create a New Post</h2>
    <form action="../api/add_post.php" method="POST" enctype="multipart/form-data">
      <label for="type">Select Type:</label>
      <select id="type" name="type" onchange="toggleCategory()" required>
        <option value="">-- Choose --</option>
        <option value="incident">Incident</option>
        <option value="feedback">General Feedback</option>
      </select>

      <div id="incident-options" class="hidden">
        <label for="category">Incident Type:</label>
        <select name="category">
          <option value="accident">Accident</option>
          <option value="complaint">Complaint</option>
          <option value="request">Request</option>
        </select>
      </div>

      <div id="feedback-options" class="hidden">
        <label for="category">Feedback Type:</label>
        <select name="category">
          <option value="compliment">Compliment</option>
          <option value="critic">Critic</option>
        </select>
      </div>

      <label for="image">Upload Image (optional):</label>
      <input type="file" name="image" accept="image/*">

      <label for="description">Describe your post:</label>
      <textarea name="description" required></textarea>

      <button type="submit">Submit Post</button>
    </form>
  </div>
</body>
</html>
