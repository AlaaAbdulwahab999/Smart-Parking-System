<?php
  define('DATABASE_QUERY_ASSOCIATIVE', true);

  class DATABASE {
    private static $connection;

    public static function connect($host, $username, $password, $dbname) {
      self::$connection = new mysqli($host, $username, $password, $dbname);
      if (self::$connection->connect_error)die("Connection failed: {self::$connection->connect_error}");
      if (!self::$connection->set_charset("utf8"))die("Error loading character set {self::$connection->error}");
      register_shutdown_function(function() { self::$connection->kill(self::$connection->thread_id); self::$connection->close(); });
    }

    public static function escape($string) { return self::$connection ? 'UNHEX(\'' . bin2hex($string) . '\')': false; }

    private static function _query($query) { return self::$connection ? self::$connection->query(preg_replace("/'UNHEX\('([0-9a-f]*)'\)'/", "UNHEX('$1')", $query)) : false; }

    public static function query($query, $assoc = DATABASE_QUERY_ASSOCIATIVE, callable $callback=null) {
      $result = self::_query($query);
      if($result && (!strcasecmp(substr($query,0,6), 'SELECT') || !strcasecmp(substr($query,0,4), 'SHOW'))) {
        if($callback) {
          if($assoc)while($row = $result->fetch_assoc())$callback($row);
          else while($row = $result->fetch_row())$callback($row);
          $result->free_result();
          $result = true;
        } else {
          $temp_arr = array();
          if($assoc)while($row = $result->fetch_assoc())$temp_arr[] = $row;
          else while($row = $result->fetch_row())$temp_arr[] = $row;
          $result->free_result();
          $result = $temp_arr;
        }
      }
      return $result;
    }

    public static function setTimezone($timezone) {
      $timezone = self::escape($timezone);
      self::query("SET @@session.time_zone='{$timezone}'");
    }
  }
?>
