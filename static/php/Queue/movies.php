<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $MOVIES_QUEUE = json_decode(file_get_contents("${RADARR}/api/queue?apikey=${API_KEY_RADARR}"), true);

  foreach($MOVIES_QUEUE as &$movie){
    $movie['movie']['images'][0]['url'] = "/static/php/Shared/image.php?tmdb_id=" . $movie['movie']['tmdbId'];
  }
  echo json_encode($MOVIES_QUEUE);

?>