<?php

  include "../Config/conf.php";
  header("Content-Type: image/jpeg;");

  if (isset($_GET['tmdb_id'])) {
    $TMDB_JSON = json_decode(file_get_contents("https://api.themoviedb.org/3/movie/" . $_GET['tmdb_id'] . "?api_key=${API_KEY_TMDB}"), true);
    $IMAGE_URL = "http://image.tmdb.org/t/p/w200" . $TMDB_JSON['poster_path'];
    $IMAGE = file_get_contents($IMAGE_URL);
    echo $IMAGE;
  } else if (isset($_GET['rating_key']) && isset($_GET['type'])) {
    if ($_GET['type'] == "art") {
      $OPTIONS = "&height=270&opacity=40&background=282828&blur=3&fallback=art&refresh=true";
    } else {
      $OPTIONS = "&height=270&fallback=thumb&refresh=true";
    }
    $IMAGE_URL = "${TAUTULLI}/pms_image_proxy?img=/library/metadata/" . $_GET['rating_key'] . "/" . $_GET['type'] . $OPTIONS;
    $IMAGE = file_get_contents($IMAGE_URL);
    echo $IMAGE;
  }

?>