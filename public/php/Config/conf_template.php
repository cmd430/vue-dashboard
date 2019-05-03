<?php

  $GLOBAL_HOST = "<your host ip here | e.g 127.0.0.1>";
  $CONFIG = [
    "PLEX" => [
      "API_KEY" => "<your PLEX api key here>",
      "URL" => "http://{$GLOBAL_HOST}:32400/statistics"
    ],
    "SONARR" => [
      "API_KEY" => "<your SONARR api key here>",
      "URL" => "http://{$GLOBAL_HOST}:8989/api"
    ],
    "RADARR" => [
      "API_KEY" => "<your RADARR api key here>",
      "URL" => "http://{$GLOBAL_HOST}:7878/api"
    ],
    "TAUTULLI" => [
      "API_KEY" => "<your TAUTULLI api key here>",
      "URL" => "http://{$GLOBAL_HOST}:9191/api/v2"
    ],
    "QBITTORRENT" => [
      "URL" => "http://{$GLOBAL_HOST}:8112/api/v2"
    ],
    "TMDB" => [
      "API_KEY" => "<your TMDB api key here>",
    ],
    "PROXY" => [
      "IMAGE" => "/php/Shared/image.php"
    ]
  ];

?>