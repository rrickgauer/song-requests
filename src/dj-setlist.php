<?php
session_start();
include('functions.php');
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
    <h1 class="text-center mt-3 mb-5"><?php echo $setlist['name']; ?></h1>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-setlist-info">Setlist info</button>

    <h5 class="mb-3">Setlist data</h5>
    <!-- setlist info table -->
    <table class="table table-sm table-striped">
      <tbody>
        <tr>
          <th>setlist name</th>
          <td><?php echo $setlist['name']; ?></td>
        </tr>

        <tr>
          <th>dj</th>
          <td><?php echo $setlist['username']; ?></td>
        </tr>

        <tr>
          <th>status</th>
          <td><?php echo $setlist['status']; ?></td>
        </tr>

        <tr>
          <th>time_start</th>
          <td><?php echo $setlist['time_start']; ?></td>
        </tr>

        <tr>
          <th>time_start_display_date</th>
          <td><?php echo $setlist['time_start_display_date']; ?></td>
        </tr>

        <tr>
          <th>time_start_display_time</th>
          <td><?php echo $setlist['time_start_display_time']; ?></td>
        </tr>

        <tr>
          <th>time_end</th>
          <td><?php echo $setlist['time_end']; ?></td>
        </tr>

        <tr>
          <th>time_end_display_date</th>
          <td><?php echo $setlist['time_end_display_date']; ?></td>
        </tr>

        <tr>
          <th>time_end_display_time</th>
          <td><?php echo $setlist['time_end_display_time']; ?></td>
        </tr>

      </tbody>
    </table>
      

  </div>

  <!-- setlist info -->
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

                <button type="button" class="btn btn-primary float-right">Edit</button>
              </form>

        </div>
      </div>
    </div>
  </div>

  <?php include('footer.php'); ?>
  <script src="js/dj-setlist-js.js"></script>

</body>
</html>