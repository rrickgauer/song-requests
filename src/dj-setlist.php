<?php
session_start();
include('functions.php');

// user edited the setlist info
if (isset(
  $_GET['id'], 
  $_POST['edit-setlist-name'], 
  $_POST['edit-setlist-time-start'], 
  $_POST['edit-setlist-time-end'], 
  $_POST['edit-setlist-status'])) 
{

  // send update to the server
  $result = updateSetlist(
    $_GET['id'], 
    $_POST['edit-setlist-name'], 
    $_POST['edit-setlist-status'], 
    $_POST['edit-setlist-time-start'], 
    $_POST['edit-setlist-time-end']);

  // check if update was successful and set the flag
  $setlistInfoUpdated = false;
  if ($result->rowCount() == 1) {
    $setlistInfoUpdated = true;
  }
}

$setlist = getSetlistData($_GET['id'])->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <!-- flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <title><?php echo $setlist['name']; ?></title>
</head>
<body>
  <?php include('navbar.php'); ?>
  <div class="container">

    <?php  
    if (isset($setlistInfoUpdated) && $setlistInfoUpdated == true)
      echo getAlert('Info ipdated');
    ?>

    <h1 class="text-center mt-3 mb-5"><?php echo $setlist['name']; ?></h1>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-setlist-info">Setlist info</button>

    


    <div class="split">
      <div class="left">
        <h5 class="mr-2">Requests</h5>
      </div>

      <div class="right d-flex">
        
        <!-- filter by status -->

        <div class="dropdown dropdown-filter-status">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
            Status filter
          </button>
          <div class="dropdown-menu">
            <button class="dropdown-item active" type="button" data-filter-value="all">All</button>
            <button class="dropdown-item" type="button" data-filter-value="approved">Approved</button>
            <button class="dropdown-item" type="button" data-filter-value="denied">Denied</button>
            <button class="dropdown-item" type="button" data-filter-value="pending">Pending</button>
          </div>
        </div>




        <input type="text" class="form-control" id="table-search-input" placeholder="Search here...">
      </div>
    </div>


    <!-- requests table -->
    <div class="table-responsive" id="requests">
      <table class="table table-requests" id="table-requests">
        <thead>
          <tr>
            <th>Title</th>
            <th>Artist</th>
            <th data-sort-method="number">Votes</th>
            <th data-sort-method="number">Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>

  </div>

  <!-- setlist info modal -->
  <div class="modal fade" id="modal-setlist-info" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Setlist info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
            <!-- edit setlist info -->
              <form method="post">
                <!-- setlist name -->
                <div class="form-group">
                  <label for="edit-setlist-name">Name:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class='bx bxs-playlist'></i></span>
                    </div>
                    <input type="text" class="form-control edit-setlist edit-setlist-name" id="edit-setlist-name" name="edit-setlist-name" disabled required>
                  </div>
                </div>

                <!-- time start -->
                <div class="form-group">
                  <label for="edit-setlist-time-start">Start time:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class='bx bx-calendar-plus'></i></span>
                    </div>
                    <input type="text" class="form-control edit-setlist edit-setlist-time edit-setlist-time-start" id="edit-setlist-time-start" name="edit-setlist-time-start" required disabled>
                  </div>
                </div>

                <!-- time end -->
                <div class="form-group">
                  <label for="edit-setlist-time-end">End time:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class='bx bx-calendar-x'></i></span>
                    </div>
                    <input type="text" class="form-control edit-setlist edit-setlist-time edit-setlist-time-end" id="edit-setlist-time-end" name="edit-setlist-time-end" required disabled>
                  </div>
                </div>

                <!-- status -->
                <div class="form-group">
                  <label for="edit-setlist-time-end">Status:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class='bx bx-stats'></i></span>
                    </div>
                    <select class="form-control edit-setlist edit-setlist-status" name="edit-setlist-status" id="edit-setlist-status" disabled>
                      <option value="open">Open</option>
                      <option value="closed">Closed</option>
                      <option value="paused">Paused</option>            
                    </select>
                  </div>
                </div>
                
                <div class="buttons">
                  <button type="button" class="btn btn-primary btn-edit-info float-right" onclick="enableEditSetlistInfoForm()">Edit</button>
                  <input type="submit" class="btn btn-success btn-save-edit-info float-right ml-2" value="Save" hidden>
                  <button type="button" class="btn btn-danger btn-cancel-edit-info float-right" onclick="cancelEditSetlistInfoForm()" hidden>Cancel</button>
                </div>
              </form>

        </div>
      </div>
    </div>
  </div>

  <?php include('footer.php'); ?>
  
  <!-- tablesort -->
  <script src="js/tablesort/tablesort.min.js"></script>
  <script src="js/tablesort/tablesort.date.min.js"></script>
  <script src="js/tablesort/tablesort.number.min.js"></script>

  <!-- tablesearch -->
  <script type="text/javascript" src="js/tablesearch.js"></script>

  <!-- custom js -->
  <script src="js/dj-setlist-js.js"></script>

</body>
</html>