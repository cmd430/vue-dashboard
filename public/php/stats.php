<?php

  require "./Config/conf.php";

  $CONFIG = new Config();

  $LIBRARY_MOVIES = $CONFIG->Tautulli("get_library", "section_id=1");
  $LIBRARY_SHOWS = $CONFIG->Tautulli("get_library", "section_id=2");
  $LIBRARY_MOVIES_WATCHTIME_STATS = $CONFIG->Tautulli("get_library_watch_time_stats", "section_id=1");
  $LIBRARY_SHOWS_WATCHTIME_STATS = $CONFIG->Tautulli("get_library_watch_time_stats", "section_id=2");
  $DISKSPACE = $CONFIG->Sonarr("diskspace");
  $BANDWIDTH_TORRENT = $CONFIG->qBittorrent("maindata");
  $BANDWIDTH_LIVE = $CONFIG->Plex("bandwidth", "timespan=6");
  $BANDWIDTH = $CONFIG->Plex("bandwidth", "timespan=1&at>=0");

  $STATS = [
    'libraries' => [
      'movies' => [
        'total' => $LIBRARY_MOVIES['response']['data']['count'],
        'plays' => $LIBRARY_MOVIES_WATCHTIME_STATS['response']['data'][3]['total_plays'],
        'time_watched' => ($LIBRARY_MOVIES_WATCHTIME_STATS['response']['data'][3]['total_time']) * 1000
      ],
      'shows' => [
        'total' => [
          'series' => $LIBRARY_SHOWS['response']['data']['count'],
          'seasons' => $LIBRARY_SHOWS['response']['data']['parent_count'],
          'episodes' => $LIBRARY_SHOWS['response']['data']['child_count']
        ],
        'plays' => $LIBRARY_SHOWS_WATCHTIME_STATS['response']['data'][3]['total_plays'],
        'time_watched' => ($LIBRARY_SHOWS_WATCHTIME_STATS['response']['data'][3]['total_time']) * 1000
      ],
      'total' => [
        'files' => $LIBRARY_MOVIES['response']['data']['count'] + $LIBRARY_SHOWS['response']['data']['child_count'],
        'plays' => $LIBRARY_MOVIES_WATCHTIME_STATS['response']['data'][3]['total_plays'] + $LIBRARY_SHOWS_WATCHTIME_STATS['response']['data'][3]['total_plays'],
        'time_watched' => ($LIBRARY_MOVIES_WATCHTIME_STATS['response']['data'][3]['total_time'] + $LIBRARY_SHOWS_WATCHTIME_STATS['response']['data'][3]['total_time']) * 1000
      ]
    ],
    'diskspace' => [
      'total' => [
        'bytes' => $DISKSPACE[0]['totalSpace']
      ],
      'free' => [
        'bytes' => $DISKSPACE[0]['freeSpace'],
        'percent' => ($DISKSPACE[0]['freeSpace'] / $DISKSPACE[0]['totalSpace']) * 100
      ],
      'used' => [
        'bytes' => $DISKSPACE[0]['totalSpace'] - $DISKSPACE[0]['freeSpace'],
        'percent' => 100 - (($DISKSPACE[0]['freeSpace'] / $DISKSPACE[0]['totalSpace']) * 100)
      ]
    ],
    'bandwidth' => [
      'qbittorrent' => [
        'live' => [
          'total' => $BANDWIDTH_TORRENT['server_state']['dl_info_speed'] + $BANDWIDTH_TORRENT['server_state']['up_info_speed'],
          'upload' => $BANDWIDTH_TORRENT['server_state']['up_info_speed'],
          'download' => $BANDWIDTH_TORRENT['server_state']['dl_info_speed']
        ],
        'total' => $BANDWIDTH_TORRENT['server_state']['alltime_dl'] + $BANDWIDTH_TORRENT['server_state']['alltime_ul'],
        'upload' => $BANDWIDTH_TORRENT['server_state']['alltime_ul'],
        'download' => $BANDWIDTH_TORRENT['server_state']['alltime_dl']
      ],
      'plex' => [
        'live' => [
          'total' => 0,
          'local' => 0,
          'remote' => 0
        ],
        'total' => 0,
        'local' => 0,
        'remote' => 0
      ],
      'total' => [
        'live' => [
          'total' => 0,
          'upload' => 0,
          'download' => 0
        ],
        'total' => 0,
        'upload' => 0,
        'download' => 0
      ]
    ]
  ];

  $ACCOUNTS_LIVE = [];
  foreach ($BANDWIDTH_LIVE['MediaContainer']['Account'] as $Account) {
    foreach (array_reverse($BANDWIDTH_LIVE['MediaContainer']['StatisticsBandwidth'], true) as $account_bandwidth) {
      if ($account_bandwidth['accountID'] == $Account['id'] && !in_array($Account['id'], $ACCOUNTS_LIVE)) {
        $ACCOUNTS_LIVE[] = $Account['id'];
        $STATS['bandwidth']['plex']['live']['total'] += $account_bandwidth['bytes'] * 8;
        if ($account_bandwidth['lan'] === true) {
          $STATS['bandwidth']['plex']['live']['local'] += $account_bandwidth['bytes'] * 8;
        } else {
          $STATS['bandwidth']['plex']['live']['remote'] += $account_bandwidth['bytes'] * 8;
        }
      }
    }
  }
  foreach ($BANDWIDTH['MediaContainer']['StatisticsBandwidth'] as $bandwidth) {
    $STATS['bandwidth']['plex']['total'] += $bandwidth['bytes'];
    if ($bandwidth['lan'] === true) {
      $STATS['bandwidth']['plex']['local'] += $bandwidth['bytes'];
    } else {
      $STATS['bandwidth']['plex']['remote'] += $bandwidth['bytes'];
    }
  }
  $STATS['bandwidth']['total']['live']['total'] += $STATS['bandwidth']['qbittorrent']['live']['total'] + $STATS['bandwidth']['plex']['live']['total'];
  $STATS['bandwidth']['total']['live']['upload'] += $STATS['bandwidth']['qbittorrent']['live']['upload'] + $STATS['bandwidth']['plex']['live']['total'];
  $STATS['bandwidth']['total']['live']['download'] += $STATS['bandwidth']['qbittorrent']['live']['download'];
  $STATS['bandwidth']['total']['total'] += $STATS['bandwidth']['qbittorrent']['total'] + $STATS['bandwidth']['plex']['total'];
  $STATS['bandwidth']['total']['upload'] += $STATS['bandwidth']['plex']['total'] + $STATS['bandwidth']['qbittorrent']['upload'];
  $STATS['bandwidth']['total']['download'] += $STATS['bandwidth']['qbittorrent']['download'];

  header("Content-Type: application/json");
  echo json_encode($STATS);

?>