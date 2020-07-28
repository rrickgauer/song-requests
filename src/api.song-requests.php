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
  // echo $_SESSION['id'];
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









?>