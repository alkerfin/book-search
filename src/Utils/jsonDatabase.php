<?php
namespace App\Utils;
class jsonDatabase {
    private function in_json_array($field,$needle,$haystack) {
      for($i = 0;$i < count($haystack);$i++) {
        if(isset($haystack[$i][$field])) {
          if($haystack[$i][$field] === $needle) {
            return true;
          }
        }
      }
      return false;
    }

    public function SaveToFile($fname,$data) {
      $contents = file_get_contents($fname);
      $fh = fopen($fname,"w");

      if($contents == "") {
        fwrite($fh,json_encode($data));
      } else {
        $oldData = json_decode($contents,true);

        for($i = 0;$i < count($data);$i++) {
          if(!$this->in_json_array("id",$data[$i]["id"],$oldData)) {
            $oldData[] = $data[$i];
          }
        }

        fwrite($fh,json_encode($oldData));

      }
      fclose($fh);


    }

    public function FindFromFile($fname,$qrySearch) {
      $results = [];

      $contents = file_get_contents($fname);

      if($contents == "") {
        return $results;
      }

      $json_data = json_decode($contents,true);
      if(count($json_data) < 1) {
        return $results;
      }

      for($i = 0;$i < count($json_data);$i++) {

        if(strpos($json_data[$i]["volumeInfo"]["title"],$qrySearch) !== false) {
          $results[] = $json_data[$i];
          continue;
        }

        if(!isset($json_data[$i]["volumeInfo"]["authors"])) {
          continue;
        }

        for($n = 0;$n < count($json_data[$i]["volumeInfo"]["authors"]);$n++) {
            if(strpos($json_data[$i]["volumeInfo"]["authors"][$n],$qrySearch) !== false) {
              $results[] = $json_data[$i];
              continue;
            }
        }

      }

      return $results;
    }
    public function FindFieldFromFile($fname,$field,$needle) {
      $results = [];

      $contents = file_get_contents($fname);

      if($contents == "") {
        return $results;
      }

      $json_data = json_decode($contents,true);
      if(count($json_data) < 1) {
        return $results;
      }

      for($i = 0;$i < count($json_data);$i++) {


        if(!isset($json_data[$i][$field])) {
          continue;
        }

        if($json_data[$i][$field] == $needle) {
          $results[] = $json_data[$i];
          continue;
        }

      }

      return $results;
    }
  }


?>
