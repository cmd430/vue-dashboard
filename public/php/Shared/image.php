<?php

  require "../Config/conf.php";

  $CONFIG = new Config();
  $IMAGE_CACHE_TIME = 60*60*24*3; //3 Days
  $IMAGE_URL; // Could put a Placeholder image here

  if (isset($_GET['radarr_id'])) {
    $IMAGE_URL = $CONFIG->Radarr("MediaCover/{$_GET['radarr_id']}/poster.jpg", null, false);
  } else if (isset($_GET['sonarr_id'])) {
    $IMAGE_URL = $CONFIG->Sonarr("MediaCover/{$_GET['sonarr_id']}/poster.jpg", null, false);
  } else if (isset($_GET['rating_key']) && isset($_GET['type'])) {
    $TYPE = $_GET['type'];
    if ($_GET['type'] == "art") {
      $OPTIONS = "&height=270&opacity=40&background=282828&blur=3&fallback=art";
    } else {
      $OPTIONS = "&height=270&fallback=thumb";
    }
    $IMAGE_URL = $CONFIG->Tautulli("pms_image_proxy", "img=/library/metadata/{$_GET['rating_key']}/{$TYPE}{$OPTIONS}", false);
  }

  header("Content-Type: image/jpeg;");
  echo file_get_contents($IMAGE_URL);

?>