<?php

  class Config {

    /** USER EDITABLE SETTINGS
     ******************************************/

    // Connections
    private const PLEX_CONNECTION =        "<http | https>";
    private const SONARR_CONNECTION =      "<http | https>";
    private const RADARR_CONNECTION =      "<http | https>";
    private const PROWLARR_CONNECTION =    "<http | https>";
    private const TAUTULLI_CONNECTION =    "<http | https>";
    private const QBITTORRENT_CONNECTION = "<http | https>";

    // Hosts
    private const PLEX_HOST =              "<your plex host ip here | e.g 127.0.0.1>";
    private const SONARR_HOST =            "<your sonarr host ip here | e.g 127.0.0.1>";
    private const RADARR_HOST =            "<your radarr host ip here | e.g 127.0.0.1>";
    private const PROWLARR_HOST =          "<your prowlarr host ip here | e.g 127.0.0.1>";
    private const TAUTULLI_HOST =          "<your tautulli host ip here | e.g 127.0.0.1>";
    private const QBITTORRENT_HOST =       "<your qbittorrent host ip here | e.g 127.0.0.1>";

    // API Keys
    private const PLEX_API_KEY =           "<your plex api key here>";
    private const SONARR_API_KEY =         "<your sonarr api key here>";
    private const RADARR_API_KEY =         "<your radarr api key here>";
    private const PROWLARR_API_KEY =       "<your prowlarr api key here>";
    private const TAUTULLI_API_KEY =       "<your tautulli api key here>";

    // Ports
    private const PLEX_PORT =              "<your plex port here | e.g 32400>";
    private const SONARR_PORT =            "<your sonarr port here | e.g 8989>";
    private const RADARR_PORT =            "<your radarr port here | e.g 7878>";
    private const PROWLARR_PORT =          "<your prowlarr port here | e.g 7878>";
    private const TAUTULLI_PORT =          "<your tautulli port here | e.g 9191>";
    private const QBITTORRENT_PORT =       "<your qbittorrent port here | e.g 8112>";

    /** DO NOT MODIFY BELOW THIS LINE
     * (unless you know what you're doing)
     ******************************************/

    public function Proxy($params) {
      return "/php/image.php?{$params}";
    }
    public function Plex($route, $params = null, $json = true) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = $this::PLEX_CONNECTION ."://" . $this::PLEX_HOST .":" . $this::PLEX_PORT ."/statistics/{$route}{$params}X-Plex-Token=" . $this::PLEX_API_KEY;
      if ($json) {
        return json_decode(file_get_contents($URL, false, stream_context_create([
          $this::PLEX_CONNECTION => [
            "method" => "GET",
            "header" => "Accept: application/json"
          ]
        ])), true);
      } else {
        return $URL;
      }
    }
    public function Sonarr($route, $params = null, $json = true) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = $this::SONARR_CONNECTION . "://" . $this::SONARR_HOST . ":" . $this::SONARR_PORT . "/api/v3/{$route}{$params}apikey=" . $this::SONARR_API_KEY;
      if ($json) {
        return json_decode(file_get_contents($URL), true);
      } else {
        return $URL;
      }
    }
    public function Radarr($route, $params = null, $json = true) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = $this::RADARR_CONNECTION ."://" . $this::RADARR_HOST .":" . $this::RADARR_PORT ."/api/v3/{$route}{$params}apikey=" . $this::RADARR_API_KEY;
      if ($json) {
        return json_decode(file_get_contents($URL), true);
      } else {
        return $URL;
      }
    }
    public function Prowlarr($route, $params = null, $json = true) {
      if (is_null($params)) {
        $params = "?";
      } else {
        $params = "?" . $params . "&";
      }
      $URL = $this::PROWLARR_CONNECTION ."://" . $this::PROWLARR_HOST .":" . $this::PROWLARR_PORT ."/api/v1/{$route}{$params}apikey=" . $this::PROWLARR_API_KEY;
      if ($json) {
        return json_decode(file_get_contents($URL), true);
      } else {
        return $URL;
      }
    }
    public function Tautulli($route, $params = null, $json = true) {
      if (is_null($params)) {
        $params = "";
      } else {
        $params = "&" . $params;
      }
      $URL = $this::TAUTULLI_CONNECTION ."://" . $this::TAUTULLI_HOST .":" . $this::TAUTULLI_PORT ."/api/v2/?apikey=" . $this::TAUTULLI_API_KEY . "&cmd={$route}{$params}";
      if ($json) {
        return json_decode(file_get_contents($URL), true);
      } else {
        return $URL;
      }
    }
    public function qBittorrent($route, $json = true) {
      $URL = $this::QBITTORRENT_CONNECTION ."://" . $this::QBITTORRENT_HOST .":" . $this::QBITTORRENT_PORT ."/api/v2/{$route}";
      if ($json) {
        return json_decode(file_get_contents($URL, false, stream_context_create([
          $this::QBITTORRENT_CONNECTION => [
            "method" => "GET",
            "timeout" => .1 // hack to make it not take FUCKING ages to close the connection
          ]
        ])), true);
      } else {
        return $URL;
      }
    }
  }

?>
