<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $START = "";
  $END =  "";

  if(isset($_GET['start'])){
    $START = "&start=" . $_GET['start'];
  }
  if(isset($_GET['end'])){
    $END = "&end=" . $_GET['end'];
  }

  $SERIES_QUEUE = json_decode(file_get_contents("${SONARR}/api/queue?apikey=${API_KEY_SONARR}"), true);
  $SERIES_CALENDAR = json_decode(file_get_contents("${SONARR}/api/calendar?apikey=${API_KEY_SONARR}&unmonitored=false" . $START . $END), true);
  $SERIES_DOWNLOADING = array();
  foreach($SERIES_QUEUE as $episode){
    array_push($SERIES_DOWNLOADING, $episode['episode']['id']);
  }
  foreach($SERIES_CALENDAR as &$episode){
    if(in_array($episode['id'], $SERIES_DOWNLOADING)){
      $episode['downloading'] = true;
    } else {
      $episode['downloading'] = false;
    }
  }

  echo json_encode($SERIES_CALENDAR);

?>