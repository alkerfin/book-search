<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Utils\httpClient;
use App\Utils\jsonDatabase;



class BookController extends Controller {

  // Handles all JSON-parsing
  public function listBooks($qrySearch) {


    $results = array();

    if(!isset($qrySearch)) {
        return new JsonResponse($results);
    }

    //Let's fetch data based by our parameters from Google Books Api
    //TODO : Use config for the API-url

    $httpC = new httpClient();

    $api_results = $httpC->HttpGet($_SERVER['API_LIST_URL'].$qrySearch);

    $jDb = new jsonDatabase();

    if($api_results != "") {
      //Let's handle the results what API gave us.
      $api_results = json_decode($api_results,true);
      if(!isset($api_results["items"])) {
        //Let's try the file
        return new JsonResponse([]);
      }
      $jDb->SaveToFile("../db/items.json",$api_results["items"]);

    }
    $api_results = array();
    $api_results["items"] = $jDb->FindFromFile("../db/items.json",$qrySearch);

    for($i = 0;$i < count($api_results["items"]);$i++) {
      $obj = array();
    //  $obj = $api_results["items"][$i];
      $obj["id"] = $api_results["items"][$i]["id"];
      $obj["title"] = $api_results["items"][$i]["volumeInfo"]["title"];
      if(isset($api_results["items"][$i]["volumeInfo"]["authors"])) {
        $obj["authors"] = $api_results["items"][$i]["volumeInfo"]["authors"];
      } else {
        $obj["authors"] = [];
      }

      if(isset($api_results["items"][$i]["volumeInfo"]["description"])) {
        $obj["description"] = substr($api_results["items"][$i]["volumeInfo"]["description"],0,100)."..."; //TODO : Substring this to only 80 chars?
      }
      else {
        $obj["description"] = "";
      }

      $results[] = $obj;

    }


    //TODO : Sort array
    return new JsonResponse($results);
  }

  public function OneBook($id) {
    if(!isset($id)) {
      return new JsonResponse(array());
    }
    $httpC = new httpClient();
    $jDb = new jsonDatabase();

    $api_results = $httpC->HttpGet($_SERVER['API_ONE_URL'].$id);
    if($api_results == "") {
      $api_results = array();
      $api_results["items"] =  $jDb->FindFieldFromFile("../db/items.json","id",$id);
    } else {
      $api_results = json_decode($api_results,true);
    }
      if(!isset($api_results["items"])) {
        return new JsonResponse([]);
      }
      if(count($api_results["items"]) > 0) {
        return new JsonResponse($api_results["items"][0]);
      } else {
        return new JsonResponse(array());
      }

  }

}
?>
