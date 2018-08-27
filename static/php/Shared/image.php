<?php

  include "../Config/conf.php";
  header("Content-Type: image/jpeg;");

  if (isset($_GET['tmdb_id'])) {
    $TMDB_ID = $_GET['tmdb_id'];
    $TMDB_JSON = json_decode(file_get_contents("https://api.themoviedb.org/3/movie/${TMDB_ID}?api_key=${API_KEY_TMDB}"), true);
    $POSTER_PATH = $TMDB_JSON['poster_path'];
    $IMAGE_URL = "http://image.tmdb.org/t/p/w200${POSTER_PATH}";
    $IMAGE = file_get_contents($IMAGE_URL);
  } else if (isset($_GET['rating_key']) && isset($_GET['type'])) {
    $TYPE = $_GET['type'];
    $RATING_KEY = $_GET['rating_key'];
    if ($_GET['type'] == "art") {
      $OPTIONS = "&height=270&opacity=40&background=282828&blur=3&fallback=art";
    } else {
      $OPTIONS = "&height=270&fallback=thumb";
    }
    $IMAGE_URL = "${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=pms_image_proxy&img=/library/metadata/${RATING_KEY}/${TYPE}${OPTIONS}";
    $IMAGE = file_get_contents($IMAGE_URL);
  }

  echo $IMAGE;

?>