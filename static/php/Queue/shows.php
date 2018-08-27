<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  echo file_get_contents("${SONARR}/queue?apikey=${API_KEY_SONARR}");

?>