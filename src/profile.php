<?php
session_start();
include('functions.php');
$djInfo = getDjInfo($_SESSION['id'])->fetch(PDO::FETCH_ASSOC);

// creat new setlist
if (isset($_POST['new-setlist-name'], $_POST['new-setlist-time-start'], $_POST['new-setlist-time-end'], $_POST['new-setlist-status'])) {
  $result = insertSetlist(
    $_SESSION['id'],
    $_POST['new-setlist-name'],
    $_POST['new-setlist-status'],
    $_POST['new-setlist-time-start'], 
    $_POST['new-setlist-time-end']
  ); 

  // go to the setlist page if successful insert
  if ($result->rowCount() == 1) {
    $setlistID = getRecentSetlistId($_SESSION['id'])->fetch(PDO::FETCH_ASSOC);
    $url = 'setlist.php?id=' . $setlistID['id'];
    header('Location: ' . $url);
    exit;
  }
}

?>


<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <!-- flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <title>DJ Profile Page</title>
</head>
<body>
  <?php include('navbar.php'); ?>
  <div class="container">
    <h1 class="mt-3 mb-5"><?php echo $djInfo['username']; ?></h1>


    <div class="row">
      
      <!-- setlists -->
      <div class="col-sm-12 col-md-9 setlists">
        <h5>Your setlists</h5>
        
        <!-- selist cards list -->
        <div id="setlists-list"></div>

      </div>
      
      <!-- create new setlist -->
      <div class="col-sm-12 col-md-3">
        <h5>New setlist</h5>
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
              <input type="text" class="form-control new-setlist new-setlist-time new-setlist-time-start" id="new-setlist-time-start" name="new-setlist-time-start" required>
            </div>
          </div>


          <!-- time end -->
          <div class="form-group">
            <label for="new-setlist-time-end">End time:</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class='bx bx-calendar-x'></i></span>
              </div>
              <input type="text" class="form-control new-setlist new-setlist-time new-setlist-time-end" id="new-setlist-time-end" name="new-setlist-time-end" required>
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

          <input type="submit" class="btn btn-primary float-right" value="Create">
        </form>
      </div>
    </div>

  </div>


  <?php include('footer.php'); ?>
  <script src="js/profile-js.js"></script>

</body>
</html>