<?php

// return a pdo database object
function dbConnect() {
  include('db-info.php');

  try {
    // connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbName",$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;

  } catch(PDOexception $e) {
      return 0;
  }
}

// insert a new dj record into db
function insertDj($username, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('INSERT INTO Djs (username, password) VALUES (:username, :password)');

  // sanitize and bind username
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  // sanitize, hash, and bind password
  $password = filter_var($password, FILTER_SANITIZE_STRING);
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $sql->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

  $sql->execute();

  return $sql;
}


// validate a users dj login attempt
function isValidUsernameAndPassword($username, $password) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT password FROM Djs WHERE username=:username LIMIT 1');

  // sanitize and bind username
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  $sql->execute();

  // username does not exist
  if ($sql->rowCount() != 1) {
    return false;
  }

  // username exists, now check if the passwords match
  else {
    $hash = $sql->fetch(PDO::FETCH_ASSOC);
    $hash = $hash['password'];

    return password_verify($password, $hash);
  }
}

// get dj id
function getDjIdFromUsername($username) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT id FROM Djs WHERE username=:username LIMIT 1');

  // sanitize and bind username
  $username = filter_var($username, FILTER_SANITIZE_STRING);
  $sql->bindParam(':username', $username, PDO::PARAM_STR);

  $sql->execute();

  $result = $sql->fetch(PDO::FETCH_ASSOC);

  return $result['id'];
}

// get dj info from id
function getDjInfo($id) {
  $pdo = dbConnect();
  $sql = $pdo->prepare('SELECT * FROM Djs WHERE id=:id LIMIT 1');

  $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
  $sql->bindParam(':id', $id, PDO::PARAM_INT);
  $sql->execute();

  return $sql;
}



?>