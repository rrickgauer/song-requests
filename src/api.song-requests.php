<?php
session_start();
include('functions.php');

// return a dj's setlist
if (isset($_GET['function'], $_SESSION['id']) && $_GET['function'] == 'get-dj-setlists') {
  $setlists = getDjSetlists($_SESSION['id'])->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($setlists);
  exit;
}

// return a djs setlists for a user
else if (isset($_GET['function'], $_GET['id']) && $_GET['function'] == 'get-dj-setlists-for-user') {
  $setlists = getDjSetlists($_GET['id'])->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($setlists);
  exit;
}

// return the results from a search query for setlists and djs
else if (isset($_GET['function'], $_GET['query']) && $_GET['function'] == 'search-djs-setlists') {
  $query = $_GET['query'];

  $data = [];
  $data['djs'] = getDjsFromSearch($query)->fetchAll(PDO::FETCH_ASSOC);
  $data['setlists'] = getSetlistsFromSearch($query)->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($data);
  exit;
}


// get a setlist's song requests
else if (isset($_GET['function'], $_GET['id']) && $_GET['function'] == 'get-setlist-requests') {
  $requests = getRequests($_GET['id'])->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($requests);
  exit;
}


// requested to add a vote up to a request
else if (isset($_POST['function'], $_POST['requestID']) && $_POST['function'] == 'vote-up') {
  $result = incrementVotesUp($_POST['requestID'])->rowCount();

  if ($result == 1)
    echo 'success';
  else
    echo 'error';

  exit;
}

// request to decrement votes down
else if (isset($_POST['function'], $_POST['requestID']) && $_POST['function'] == 'vote-down') {
  $result = decrementVotesDown($_POST['requestID'])->rowCount();

  if ($result == 1)
    echo 'success';
  else
    echo 'error';

  exit;
}


// return a setlist info
else if (isset($_GET['function'], $_GET['setlistID']) && $_GET['function'] == 'get-setlist-info') {
  $setlistID = $_GET['setlistID'];
  $setlist = getSetlistData($setlistID)->fetch(PDO::FETCH_ASSOC);
  echo json_encode($setlist);
  exit;
}




?>