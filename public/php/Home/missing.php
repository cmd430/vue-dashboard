<?php

  require "../Config/conf.php";

  $CONFIG = new Config();

  $MISSING_SHOWS = $CONFIG->Sonarr("wanted/missing", "page=1&pageSize=50&sortKey=airDateUtc&sortDir=desc&filterKey=monitored&filterValue=true");
  $MISSING_MOVIES = $CONFIG->Radarr("wanted/missing", "page=1&pageSize=50&sortKey=physicalRelease&sortDir=desc&filterKey=physicalRelease");
  $MISSING_ITEMS = [];

  foreach ($MISSING_SHOWS['records'] as $SERIES_RAW) {
    $MISSING_ITEMS[] = [
      'title' => $SERIES_RAW['title'],
      'series' => [
        'title' => $SERIES_RAW['series']['title'],
        'season' => (strlen($SERIES_RAW['seasonNumber']) > 1 ? $SERIES_RAW['seasonNumber'] : "0" . $SERIES_RAW['seasonNumber']),
        'episode' => (strlen($SERIES_RAW['episodeNumber']) > 1 ? $SERIES_RAW['episodeNumber'] : "0" . $SERIES_RAW['episodeNumber']),
        'overview' => (isset($SERIES_RAW['series']['overview']) ? $SERIES_RAW['series']['overview'] : ""),
        'poster' => $CONFIG->Proxy("sonarr_id={$SERIES_RAW['series']['id']}")
      ],
      'release' => date('c', strtotime($SERIES_RAW['airDateUtc'] . ' + ' . $SERIES_RAW['series']['runtime'] . ' minutes')),
      'overview' => (isset($SERIES_RAW['overview']) ? $SERIES_RAW['overview'] : ""),
      'mediatype' => 'episode'
    ];
  }
  foreach ($MISSING_MOVIES['records'] as $MOVIE_RAW) {
    if (isset($MOVIE_RAW['physicalRelease'])) {
      if (strtotime(date('c', strtotime($MOVIE_RAW['physicalRelease']))) < strtotime(date('c'))) {
        $MISSING_ITEMS[] = [
          'title' => $MOVIE_RAW['title'],
          'poster' => $CONFIG->Proxy("radarr_id={$MOVIE_RAW['id']}"),
          'release' => date('c', strtotime($MOVIE_RAW['physicalRelease'])),
          'overview' => (isset($MOVIE_RAW['overview']) ? $MOVIE_RAW['overview'] : ""),
          'mediatype' => 'movie'
        ];
      }
    }
  }

  usort($MISSING_ITEMS, function ($a, $b) {
    if ($a['release'] === $b['release']) return 0;
    return ($a['release'] < $b['release']) ? -1 : 1;
  });

  header("Content-Type: application/json");
  echo json_encode($MISSING_ITEMS);

?>