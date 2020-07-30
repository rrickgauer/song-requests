<?php 
include('functions.php'); 

// check if user submitted a song request
if (isset($_POST['new-request-title'], $_GET['id'])) {
  $title = $_POST['new-request-title'];
  $setlistID = $_GET['id'];

  if ($_POST['new-request-artist'] == null || $_POST['new-request-artist'] == '')
    $artist = null;
  else
    $artist = $_POST['new-request-artist'];

  // insert request
  $result = insertRequest($setlistID, $title, $artist)->rowCount();

  // set the flag to display the successful insert alert
  $insertedRequestSuccessfully = false;
  if ($result == 1) {
    $insertedRequestSuccessfully = true;
  }
}



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

    <?php 
    // display alert if request was submitted successfully
    if (isset($insertedRequestSuccessfully) && $insertedRequestSuccessfully == true)
      echo getAlert('Request submitted.');
    ?>


    <div class="split" id="setlist-toolbar">
      <div class="right">
        <h5>Requests (<?php echo $setlistInfo['count_status_all']; ?>)</h5>
      </div>

      <div class="left">

        <!-- sort dropdown -->
        <div class="dropdown setlist-dropdown-sort">
          <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
            Sort
          </button>
          <div class="dropdown-menu">
            <button class="dropdown-item active" type="button" data-sort-value="original">Original</button>
            <button class="dropdown-item" type="button" data-sort-value="artist">Artist</button>
            <button class="dropdown-item" type="button" data-sort-value="title">Song Title</button>
            <button class="dropdown-item" type="button" data-sort-value="votes">Votes</button>
          </div>
        </div>
        
        <!-- status filter dropdown -->
        <div class="dropdown setlist-dropdown-filter">
          <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
            Status
          </button>
          <div class="dropdown-menu">
            <!-- all -->
            <button class="dropdown-item active" type="button" data-filter-value="all">
              <span class="label">All</span> 
              <span class="badge badge-secondary"><?php echo $setlistInfo['count_status_all']; ?></span>
            </button>
            
            <!-- approved -->
            <button class="dropdown-item" type="button" data-filter-value="approved">
              <span class="label">Approved</span> 
              <span class="badge badge-secondary"><?php echo $setlistInfo['count_status_approved']; ?></span>
            </button>

            <!-- denied -->
            <button class="dropdown-item" type="button" data-filter-value="denied">
              <span class="label">Denied</span>
              <span class="badge badge-secondary"><?php echo $setlistInfo['count_status_denied']; ?></span>
            </button>

            <!-- pending -->
            <button class="dropdown-item" type="button" data-filter-value="pending">
              <span class="label">Pending</span>
              <span class="badge badge-secondary"><?php echo $setlistInfo['count_status_pending']; ?></span>
            </button>
          </div>
        </div>
        
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-new-request">New</button>
      </div>
    </div>


    <!-- song request cards -->
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

            <button type="submit" class="btn btn-primary float-right">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>


<?php include('footer.php'); ?>
<script src="js/setlist-js.js"></script>
</body>
</html>