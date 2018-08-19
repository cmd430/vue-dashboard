<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  echo file_get_contents("${SONARR}/api/queue?apikey=${API_KEY_SONARR}");

?>