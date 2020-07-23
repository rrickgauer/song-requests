<?php
session_start();
include('functions.php');
$djInfo = getDjInfo($_SESSION['id'])->fetch(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title>DJ Profile Page</title>
</head>
<body>
  <div class="container">

    <h1><?php echo $djInfo['username']; ?></h1>

    
    <!-- create new setlist -->
    <form method="post">
      
      <!-- setlist name -->
      <div class="form-group">
        <label for="new-setlist-name">Name:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class='bx bx-list-ul'></i></span>
          </div>
          <input type="text" class="form-control new-setlist new-setlist-name" id="new-setlist-name" name="new-setlist-name" required>
        </div>
      </div>

      <!-- time start -->
      <div class="form-group">
        <label for="new-setlist-time-start">Start time:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class='bx bx-calendar-plus'></i></span>
          </div>
          <input type="text" class="form-control new-setlist new-setlist-time-start" id="new-setlist-time-start" name="new-setlist-time-start" required>
        </div>
      </div>


      <!-- time end -->
      <div class="form-group">
        <label for="new-setlist-time-end">End time:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class='bx bx-calendar-x'></i></span>
          </div>
          <input type="text" class="form-control new-setlist new-setlist-time-end" id="new-setlist-time-end" name="new-setlist-time-end" required>
        </div>
      </div>

      <!-- status -->
      <div class="form-group">
        <label for="new-setlist-time-end">Status:</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class='bx bx-stats'></i></span>
          </div>
          <select class="form-control new-setlist new-setlist-status" name="new-setlist-status">
            <option value="open" selected>Open</option>
            <option value="closed">Closed</option>
            <option value="paused">Paused</option>            
          </select>
        </div>
      </div>

      <input type="submit" class="btn btn-primary" value="Create setlist">
    </form>


  </div>


  <?php include('footer.php'); ?>

</body>
</html>