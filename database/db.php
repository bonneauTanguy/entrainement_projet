<?php

function connectDB(){
  $host = 'sql213.infinityfree.com	';
  $user = 'if0_35638268	';
  $password = 'dzT5DIu9Osu';
  $database = 'if0_35638268_garage';
  $conn = new mysqli($host, $user, $password, $database);

  if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
  }
  else{
    return $conn;
  }
}

