<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $STATS = array();

  // Diskspace
  $DISKSPACE = json_decode(file_get_contents("${SONARR}/diskspace?apikey=${API_KEY_SONARR}"), true);

  $STATS['diskspace']['total'] = $DISKSPACE[0]['totalSpace'];
  $STATS['diskspace']['free'] = $DISKSPACE[0]['freeSpace'];
  $STATS['diskspace']['used'] = $DISKSPACE[0]['totalSpace'] - $DISKSPACE[0]['freeSpace'];
  $STATS['diskspace']['free_percent'] = ($DISKSPACE[0]['freeSpace'] / $DISKSPACE[0]['totalSpace']) * 100;
  $STATS['diskspace']['used_percent'] = 100 - (($DISKSPACE[0]['freeSpace'] / $DISKSPACE[0]['totalSpace']) * 100);

  // Bandwidth
  $BANDWIDTH_LIVE = json_decode(file_get_contents("${PLEX}/bandwidth?timespan=6&X-Plex-Token=${API_KEY_PLEX}", false, stream_context_create(array(
    'http' => array(
      'method' => "GET",
      'header' => "Accept: application/json"
    )
  ))), true);
  $BANDWIDTH = json_decode(file_get_contents("${PLEX}/bandwidth?timespan=1&at>=0&X-Plex-Token=${API_KEY_PLEX}", false, stream_context_create(array(
    'http' => array(
      'method' => "GET",
      'header' => "Accept: application/json"
    )
  ))), true);

  $STATS['bandwidth']['live']['total'] = 0;
  $STATS['bandwidth']['live']['local'] = 0;
  $STATS['bandwidth']['live']['remote'] = 0;
  $STATS['bandwidth']['total'] = 0;
  $STATS['bandwidth']['local'] = 0;
  $STATS['bandwidth']['remote'] = 0;

  //Live Bandwidth
  $ACCOUNTS_LIVE = array();
  foreach ($BANDWIDTH_LIVE['MediaContainer']['Account'] as $Account) {
    foreach (array_reverse($BANDWIDTH_LIVE['MediaContainer']['StatisticsBandwidth'], true) as $account_bandwidth) {
      if ($account_bandwidth['accountID'] == $Account['id'] && !in_array($Account['id'], $ACCOUNTS_LIVE)) {
        array_push($ACCOUNTS_LIVE, $Account['id']);
        $STATS['bandwidth']['live']['total'] += $account_bandwidth['bytes'];
        if ($account_bandwidth['lan'] === true) {
          $STATS['bandwidth']['live']['local'] += $account_bandwidth['bytes'];
        } else {
          $STATS['bandwidth']['live']['remote'] += $account_bandwidth['bytes'];
        }
      } else {
        next;
      }
    }
  }
  //Total Bandwidth
  foreach ($BANDWIDTH['MediaContainer']['StatisticsBandwidth'] as $bandwidth) {
    $STATS['bandwidth']['total'] += $bandwidth['bytes'];
    if ($bandwidth['lan'] === true) {
      $STATS['bandwidth']['local'] += $bandwidth['bytes'];
    } else {
      $STATS['bandwidth']['remote'] += $bandwidth['bytes'];
    }
  }

 echo json_encode($STATS);

?>