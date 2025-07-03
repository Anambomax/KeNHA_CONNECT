<?php
session_start();
include 'db/connection.php';

// ✅ Ensure only staff can access
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'staff') {
    header("Location: index.php");
    exit();
}

$staffId = $_SESSION['id'];
$staffDept = $_SESSION['department'];
$staffName = $_SESSION['fullname'];

// ✅ Get all relevant feedbacks for staff department
$query = "SELECT * FROM feedback 
          WHERE department = '$staffDept' 
          AND feedback_subcategory IN ('complaint', 'request') 
          ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $staffDept ?> Staff Dashboard</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f5f7fa;
    }

    h2 {
      color: #2c3e50;
    }

    .feedback-card {
      background: white;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 30px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    textarea {
      width: 100%;
      padding: 8px;
      margin: 5px 0 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    select, button {
      padding: 6px 10px;
      border-radius: 4px;
      border: 1px solid #aaa;
      margin-right: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    table, th, td {
      border: 1px solid #ccc;
    }

    th, td {
      padding: 8px;
      text-align: left;
    }

    th {
      background: #f0f0f0;
    }

    .header-bar {
      margin-bottom: 30px;
      padding: 15px;
      background: #2c3e50;
      color: white;
      border-radius: 6px;
    }
  </style>
</head>
<body>

  <div class="header-bar">
    <h2>Welcome, <?= $staffName ?> (<?= $staffDept ?> Department)</h2>
  </div>

  <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <div class="feedback-card">
      <p><strong>Feedback ID:</strong> #<?= $row['id'] ?></p>
      <p><strong>Category:</strong> <?= ucfirst($row['feedback_category']) ?> → <?= ucfirst($row['feedback_subcategory']) ?></p>
      <p><strong>Description:</strong> <?= $row['description'] ?></p>
      <p><strong>Status:</strong> <span style="color: <?= $row['status'] === 'resolved' ? 'green' : ($row['status'] === 'escalated' ? 'orange' : 'red') ?>">
        <?= ucfirst($row['status']) ?>
      </span></p>
      <p><strong>Date Submitted:</strong> <?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></p>

      <!-- ✅ Status Update Form -->
      <form action="api/update_status_staff.php" method="POST">
        <input type="hidden" name="feedback_id" value="<?= $row['id'] ?>">
        <label>Status:</label>
        <select name="status">
          <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
          <option value="resolved" <?= $row['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
          <option value="escalated" <?= $row['status'] === 'escalated' ? 'selected' : '' ?>>Escalated</option>
        </select>
        <button type="submit">Update</button>
      </form>

      <!-- ✅ Add Progress Update -->
      <form action="api/add_submission_update.php" method="POST">
        <input type="hidden" name="feedback_id" value="<?= $row['id'] ?>">
        <label>Add Progress Update:</label>
        <textarea name="update_text" rows="3" placeholder="Write update..." required></textarea>
        <button type="submit">Add Update</button>
      </form>

      <!-- ✅ Show Update History -->
      <h4>Progress History</h4>
      <table>
        <thead>
          <tr>
            <th>Update</th>
            <th>Added By</th>
            <th>Time</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $fid = $row['id'];
          $updates = mysqli_query($conn, "
            SELECT s.update_text, s.created_at, u.fullname 
            FROM submissions s
            JOIN users u ON s.added_by = u.id
            WHERE s.feedback_id = $fid
            ORDER BY s.created_at ASC
          ");
          if (mysqli_num_rows($updates) > 0) {
            while ($update = mysqli_fetch_assoc($updates)) {
              echo "<tr>
                      <td>{$update['update_text']}</td>
                      <td>{$update['fullname']}</td>
                      <td>{$update['created_at']}</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='3'><em>No updates yet.</em></td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  <?php endwhile; ?>

</body>
</html>
