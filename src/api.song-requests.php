<?php
session_start();
include('functions.php');

// return a dj's setlist
if (isset($_GET['function'], $_SESSION['id']) && $_GET['function'] == 'get-dj-setlists') {
  $setlists = getDjSetlists($_SESSION['id'])->fetchAll(PDO::FETCH_ASSOC);
  echo json_encode($setlists);
  exit;
}








?>