<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $START = "";
  $END =  "";

  if (isset($_GET['start'])) {
    $START = "&start=" . $_GET['start'];
  }
  if (isset($_GET['end'])) {
    $END = "&end=" . $_GET['end'];
  }

  $SERIES_QUEUE = json_decode(file_get_contents("${SONARR}/queue?apikey=${API_KEY_SONARR}"), true);
  $SERIES_CALENDAR = json_decode(file_get_contents("${SONARR}/calendar?apikey=${API_KEY_SONARR}&unmonitored=false" . $START . $END), true);
  $SERIES_DOWNLOADING = array();
  $SERIES_IDS = array();
  foreach ($SERIES_QUEUE as $episode) {
    array_push($SERIES_DOWNLOADING, $episode['episode']['id']);
  }
  $i = 0;
  foreach ($SERIES_CALENDAR as &$episode) {
    if (in_array($episode['id'], $SERIES_DOWNLOADING)) {
      $episode['downloading'] = true;
      $episode['trackedDownloadStatus'] = $SERIES_QUEUE[$i]['trackedDownloadStatus'];
      $i++;
    } else {
      $episode['downloading'] = false;
    }
    if ($episode['hasFile'] === false && !in_array($episode['seriesId'], $SERIES_IDS, true)) {
      array_push($SERIES_IDS, $episode['seriesId']);
      $episode['nextEpisode'] = true;
    } else {
      $episode['nextEpisode'] = false;
    }
  }

  echo json_encode($SERIES_CALENDAR);

?>