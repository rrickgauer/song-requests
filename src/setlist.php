<?php 
include('functions.php'); 
$setlistInfo = getSetlistData($_GET['id'])->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <?php include('header.php'); ?>
  <title><?php echo $setlistInfo['name']; ?></title>
</head>
<body>
  <div class="container">

    <h1 class="text-center mt-5"><?php echo $setlistInfo['name']; ?></h1>
    <p class="text-center"><?php echo $setlistInfo['username']; ?></p>

    <!-- song request cards -->
    <div class="split mb-3">
      <div class="left">
        <h5>Requests</h5>
      </div>
      <div class="right">
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-new-request">New</button>
      </div>
    </div>
    
    <div class="song-requests"></div>

  </div>

  <!-- new song-request modal -->
  <div class="modal fade" id="modal-new-request" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New song request</h5>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post">
            <!-- song title -->
            <div class="form-group">
              <label for="new-request-title">Title:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='bx bx-music'></i></span>
                </div>
                <input type="text" class="form-control" id="new-request-title" name="new-request-title" placeholder="Enter title here" required>
              </div>
            </div>

            <!-- song artist -->
            <div class="form-group">
              <label for="new-request-artist">Artist:</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class='bx bx-user'></i></span>
                </div>
                <input type="text" class="form-control" id="new-request-artist" name="new-request-artist" placeholder="Enter artist here">
              </div>
            </div>

            <input type="submit" class="btn btn-primary float-right" value="Submit">
          </form>
        </div>
      </div>
    </div>
  </div>


<?php include('footer.php'); ?>
<script src="js/setlist-js.js"></script>
</body>
</html>