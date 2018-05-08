<?php
namespace App\Utils;
class httpClient {
  public static function HttpGet($url) {

      $opts = array(
      'http'=>array(
        'user_agent' => 'Mozilla/4.0 (compatible; MSIE 6.0)',
        'method'=>"GET"
      ),
      "ssl"=>array(
      "verify_peer"=>false,
      "verify_peer_name"=>false,
      )
    );

    $context = stream_context_create($opts);
      $result = @file_get_contents($url,false,$context);

      if($result === false) {
        return "";
      } else {
        return $result;
      }
  }
}
?>
