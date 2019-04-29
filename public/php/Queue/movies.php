<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $MOVIES_QUEUE = json_decode(file_get_contents("${RADARR}/queue?apikey=${API_KEY_RADARR}"), true);

  foreach ($MOVIES_QUEUE as &$movie) {
    $TMDB_ID = $movie['movie']['tmdbId'];
    $movie['movie']['images'][0]['url'] = "${IMAGE_PROXY}?tmdb_id=${TMDB_ID}";
  }
  echo json_encode($MOVIES_QUEUE);

?>