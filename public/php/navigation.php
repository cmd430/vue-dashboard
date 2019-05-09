<?php

  require "./Config/conf.php";

  $CONFIG = new Config();
  $SONARR_UPDATE = $CONFIG->Sonarr("update")[0];
  $RADARR_UPDATE = $CONFIG->Radarr("update")[0];
  $TAUTULLI_UPDATE = $CONFIG->Tautulli("update_check")['response']['data']['update'];

  $UPDATES = [
    'sonarr' => (($SONARR_UPDATE['installed'] === false && $SONARR_UPDATE['latest'] === true) ? true : false),
    'radarr' => (($RADARR_UPDATE['installed'] === false && $RADARR_UPDATE['latest'] === true) ? true : false),
    'tautulli' => $TAUTULLI_UPDATE
  ];

  header("Content-Type: application/json");
  echo json_encode($UPDATES);

?>