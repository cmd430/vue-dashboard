<?php

  class Config {

    /** USER EDITABLE SETTINGS
     ******************************************/

    // Connections
    private $PLEX_CONNECTION =        "<http | https>";
    private $SONARR_CONNECTION =      "<http | https>";
    private $RADARR_CONNECTION =      "<http | https>";
    private $TAUTULLI_CONNECTION =    "<http | https>";
    private $QBITTORRENT_CONNECTION = "<http | https>";

    // Hosts
    private $PLEX_HOST =              "<your plex host ip here | e.g 127.0.0.1>";
    private $SONARR_HOST =            "<your sonarr host ip here | e.g 127.0.0.1>";
    private $RADARR_HOST =            "<your radarr host ip here | e.g 127.0.0.1>";
    private $TAUTULLI_HOST =          "<your tautulli host ip here | e.g 127.0.0.1>";
    private $QBITTORRENT_HOST =       "<your qbittorrent host ip here | e.g 127.0.0.1>";

    // API Keys
    private $PLEX_API_KEY =           "<your plex api key here>";
    private $SONARR_API_KEY =         "<your sonarr api key here>";
    private $RADARR_API_KEY =         "<your radarr api key here>";
    private $TAUTULLI_API_KEY =       "<your tautulli api key here>";
    private $TMDB_API_KEY =           "<your tmdb api key here>";

    // Ports
    private $PLEX_PORT =              "<your plex port here | e.g 32400>";
    private $SONARR_PORT =            "<your sonarr port here | e.g 8989>";
    private $RADARR_PORT =            "<your radarr port here | e.g 7878>";
    private $TAUTULLI_PORT =          "<your tautulli port here | e.g 9191>";
    private $QBITTORRENT_PORT =       "<your qbittorrent port here | e.g 8112>";

    /** DO NOT MODIFY BELOW THIS LINE
     * (unless you know what you're doing)
     ******************************************/

    public function Plex($route, $params = null) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = "{$this->PLEX_CONNECTION}://{$this->PLEX_HOST}:{$this->PLEX_PORT}/statistics/{$route}{$params}X-Plex-Token={$this->PLEX_API_KEY}";
      return json_decode(file_get_contents($URL, false, stream_context_create([
        "{$this->PLEX_CONNECTION}" => [
          "method" => "GET",
          "header" => "Accept: application/json"
        ]
      ])), true);
    }
    public function Sonarr($route, $params = null) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = "{$this->SONARR_CONNECTION}://{$this->SONARR_HOST}:{$this->SONARR_PORT}/api/{$route}{$params}apikey={$this->SONARR_API_KEY}";
      return json_decode(file_get_contents($URL), true);
    }
    public function Radarr($route, $params = null) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = "{$this->RADARR_CONNECTION}://{$this->RADARR_HOST}:{$this->RADARR_PORT}/api/{$route}{$params}apikey={$this->RADARR_API_KEY}";
      return json_decode(file_get_contents($URL), true);
    }
    public function Tautulli($route, $params = null) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = "{$this->TAUTULLI_CONNECTION}://{$this->TAUTULLI_HOST}:{$this->TAUTULLI_PORT}/api/v2/{$route}{$params}apikey={$this->TAUTULLI_API_KEY}";
      return json_decode(file_get_contents($URL), true);
    }
    public function qBittorrent($route, $params = null) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = "{$this->QBITTORRENT_CONNECTION}://{$this->QBITTORRENT_HOST}:{$this->QBITTORRENT_PORT}/api/v2/sync/{$route}{$params}";
      return json_decode(file_get_contents($URL, false, stream_context_create([
        "{$this->QBITTORRENT_CONNECTION}" => [
          "method" => "GET",
          "timeout" => .1 // hack to make it not take FUCKING ages to close the connection
        ]
      ])), true);
    }
    public function Proxy($type = "image") {
      if ($type === "image") {
        return [
          "url" => "/php/Shared/image.php",
          "tmdb_key" => $this->TMDB_API_KEY
        ];
      }
    }
  }

?>