<?php

  include "../Config/conf.php";
  header("Content-Type: application/json");

  $STATS = array();

  // Libaries
  $LIBRARY_MOVIES = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_library&section_id=1"), true);
  $LIBRARY_SHOWS = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_library&section_id=2"), true);
  $LIBRARY_MOVIES_WATCHTIME_STATS = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_library_watch_time_stats&section_id=1"), true);
  $LIBRARY_SHOWS_WATCHTIME_STATS = json_decode(file_get_contents("${TAUTULLI}?apikey=${API_KEY_TAUTULLI}&cmd=get_library_watch_time_stats&section_id=2"), true);

  $STATS['libraries']['movies']['total'] = $LIBRARY_MOVIES['response']['data']['count'];
  $STATS['libraries']['movies']['plays'] = $LIBRARY_MOVIES_WATCHTIME_STATS['response']['data'][3]['total_plays'];
  $STATS['libraries']['movies']['time_watched'] = $LIBRARY_MOVIES_WATCHTIME_STATS['response']['data'][3]['total_time'];
  $STATS['libraries']['shows']['total']['series'] = $LIBRARY_SHOWS['response']['data']['count'];
  $STATS['libraries']['shows']['total']['seasons'] = $LIBRARY_SHOWS['response']['data']['parent_count'];
  $STATS['libraries']['shows']['total']['episodes'] = $LIBRARY_SHOWS['response']['data']['child_count'];
  $STATS['libraries']['shows']['plays'] = $LIBRARY_SHOWS_WATCHTIME_STATS['response']['data'][3]['total_plays'];
  $STATS['libraries']['shows']['time_watched'] = $LIBRARY_SHOWS_WATCHTIME_STATS['response']['data'][3]['total_time'];
  $STATS['libraries']['total']['files'] = $LIBRARY_MOVIES['response']['data']['count'] + $LIBRARY_SHOWS['response']['data']['child_count'];
  $STATS['libraries']['total']['plays'] = $LIBRARY_MOVIES_WATCHTIME_STATS['response']['data'][3]['total_plays'] + $LIBRARY_SHOWS_WATCHTIME_STATS['response']['data'][3]['total_plays'];
  $STATS['libraries']['total']['time_watched'] = $LIBRARY_MOVIES_WATCHTIME_STATS['response']['data'][3]['total_time'] + $LIBRARY_SHOWS_WATCHTIME_STATS['response']['data'][3]['total_time'];

  // Diskspace
  $DISKSPACE = json_decode(file_get_contents("${SONARR}/diskspace?apikey=${API_KEY_SONARR}"), true);

  $STATS['diskspace']['total'] = $DISKSPACE[0]['totalSpace'];
  $STATS['diskspace']['free'] = $DISKSPACE[0]['freeSpace'];
  $STATS['diskspace']['used'] = $DISKSPACE[0]['totalSpace'] - $DISKSPACE[0]['freeSpace'];
  $STATS['diskspace']['free_percent'] = ($DISKSPACE[0]['freeSpace'] / $DISKSPACE[0]['totalSpace']) * 100;
  $STATS['diskspace']['used_percent'] = 100 - (($DISKSPACE[0]['freeSpace'] / $DISKSPACE[0]['totalSpace']) * 100);

  // Bandwidth
  $BANDWIDTH_TORRENT = json_decode(file_get_contents("${QBITTORRENT}/sync/maindata", false, stream_context_create(array(
    'http' => array(
      'method' => "GET",
      'timeout' => .1 // hack to make it not take FUCKING ages to close the connection
    )
  ))), true);
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

  // Plex Stats
  $STATS['bandwidth']['plex']['live']['total'] = 0;
  $STATS['bandwidth']['plex']['live']['local'] = 0;
  $STATS['bandwidth']['plex']['live']['remote'] = 0;
  $STATS['bandwidth']['plex']['total'] = 0;
  $STATS['bandwidth']['plex']['local'] = 0;
  $STATS['bandwidth']['plex']['remote'] = 0;

  // qBittorrent Stats
  $STATS['bandwidth']['qbittorrent']['live']['total'] = 0;
  $STATS['bandwidth']['qbittorrent']['live']['upload'] = 0;
  $STATS['bandwidth']['qbittorrent']['live']['download'] = 0;
  $STATS['bandwidth']['qbittorrent']['total'] = 0;
  $STATS['bandwidth']['qbittorrent']['upload'] = 0;
  $STATS['bandwidth']['qbittorrent']['download'] = 0;

  // Combined Stats
  $STATS['bandwidth']['live']['total'] = 0;
  $STATS['bandwidth']['live']['upload'] = 0;
  $STATS['bandwidth']['live']['download'] = 0;
  $STATS['bandwidth']['total'] = 0;
  $STATS['bandwidth']['upload'] = 0;
  $STATS['bandwidth']['download'] = 0;

  //Live Plex Bandwidth
  $ACCOUNTS_LIVE = array();
  foreach ($BANDWIDTH_LIVE['MediaContainer']['Account'] as $Account) {
    foreach (array_reverse($BANDWIDTH_LIVE['MediaContainer']['StatisticsBandwidth'], true) as $account_bandwidth) {
      if ($account_bandwidth['accountID'] == $Account['id'] && !in_array($Account['id'], $ACCOUNTS_LIVE)) {
        array_push($ACCOUNTS_LIVE, $Account['id']);
        $STATS['bandwidth']['plex']['live']['total'] += $account_bandwidth['bytes'];
        if ($account_bandwidth['lan'] === true) {
          $STATS['bandwidth']['plex']['live']['local'] += $account_bandwidth['bytes'];
        } else {
          $STATS['bandwidth']['plex']['live']['remote'] += $account_bandwidth['bytes'];
        }
      } else {
        next;
      }
    }
  }
  //Total Plex Bandwidth
  foreach ($BANDWIDTH['MediaContainer']['StatisticsBandwidth'] as $bandwidth) {
    $STATS['bandwidth']['plex']['total'] += $bandwidth['bytes'];
    if ($bandwidth['lan'] === true) {
      $STATS['bandwidth']['plex']['local'] += $bandwidth['bytes'];
    } else {
      $STATS['bandwidth']['plex']['remote'] += $bandwidth['bytes'];
    }
  }

  // Live qBittorrent Bandwidth
  $STATS['bandwidth']['qbittorrent']['live']['total'] += $BANDWIDTH_TORRENT['server_state']['dl_info_speed'] + $BANDWIDTH_TORRENT['server_state']['up_info_speed'];
  $STATS['bandwidth']['qbittorrent']['live']['upload'] += $BANDWIDTH_TORRENT['server_state']['up_info_speed'];
  $STATS['bandwidth']['qbittorrent']['live']['download'] +=  $BANDWIDTH_TORRENT['server_state']['dl_info_speed'];

  // Total qBittorrent Bandwidth
  $STATS['bandwidth']['qbittorrent']['total'] += $BANDWIDTH_TORRENT['server_state']['alltime_dl'] + $BANDWIDTH_TORRENT['server_state']['alltime_ul'];
  $STATS['bandwidth']['qbittorrent']['upload'] += $BANDWIDTH_TORRENT['server_state']['alltime_ul'];
  $STATS['bandwidth']['qbittorrent']['download'] += $BANDWIDTH_TORRENT['server_state']['alltime_dl'];

  // Combined Live Bandwidth
  $STATS['bandwidth']['live']['total'] += $STATS['bandwidth']['qbittorrent']['live']['total'] + $STATS['bandwidth']['plex']['live']['total'];
  $STATS['bandwidth']['live']['upload'] += $STATS['bandwidth']['qbittorrent']['live']['upload'] + $STATS['bandwidth']['plex']['live']['total'];
  $STATS['bandwidth']['live']['download'] += $STATS['bandwidth']['qbittorrent']['live']['download'];

  // Combined Total Bandwidth
  $STATS['bandwidth']['total'] += $STATS['bandwidth']['qbittorrent']['total'] + $STATS['bandwidth']['plex']['total'];
  $STATS['bandwidth']['upload'] += $STATS['bandwidth']['plex']['total'] + $STATS['bandwidth']['qbittorrent']['upload'];
  $STATS['bandwidth']['download'] += $STATS['bandwidth']['qbittorrent']['download'];

 echo json_encode($STATS);
?>