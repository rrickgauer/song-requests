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
  <title><?php echo $djInfo['username']; ?></title>
</head>
<body>
  <?php include('navbar.php'); ?>
  <div class="container">
  
    <div class="split mt-3 mb-5">
      <div class="left">
        <h1 class="custom-font"><?php echo $djInfo['username']; ?></h1>
      </div>
      <div class="right">
        <a href="account-settings.php">Settings</a>
      </div>
    </div>

    <div class="row">
      
      <!-- create new setlist -->
      <div class="col-sm-12 col-md-3">
        <h5 class="mb-4">Actions</h5>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-new-setlist">Create</button>
      </div>

      <!-- setlists -->
      <div class="col-sm-12 col-md-9 setlists">
        
        <div class="split">
          <div class="left">
            <h5>Your setlists</h5>
          </div>
          <div class="right">
            <span class="mr-3 font-weight-bold">Sort:&nbsp</span>
            <select class="form-control" id="sort-setlists-select">
              <option value="time-start">Start time</option>
              <option value="name">Alphabetical</option>
            </select>
          </div>
        </div>

        
        <!-- selist cards list -->
        <div id="setlists-list"></div>

      </div>
    </div>
  </div>

  <!-- new setlist modal -->
  <div class="modal modal-new-setlist fade " id="modal-new-setlist">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New setlist</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">
            <!-- setlist name -->
            <div class="form-group">
              <label for="new-setlist-name">Name:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="bx bxs-playlist"></i></span>
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
  </div>


  <?php include('footer.php'); ?>
  <script src="js/profile-js.js"></script>

</body>
</html>