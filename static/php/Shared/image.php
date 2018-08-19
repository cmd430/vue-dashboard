<?php

  include "../Config/conf.php";
  header("Content-Type: image/jpeg;");

  if(isset($_GET['tmdb_id'])){
    $TMDB_JSON = json_decode(file_get_contents("https://api.themoviedb.org/3/movie/" . $_GET['tmdb_id'] . "?api_key=${API_KEY_TMDB}"), true);
    $IMAGE_URL = "http://image.tmdb.org/t/p/w200" . $TMDB_JSON['poster_path'];
    $IMAGE = file_get_contents($IMAGE_URL);
    echo $IMAGE;
  }

?>