<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class UiController extends Controller {
  // Handles all JSON-parsing
  public function FrontPage() {
  //  return new JsonResponse(array(array("testi"=>"hello world"),array("testi"=>"hello world2")));
    return $this->render('frontpage.html.twig');
  }

}
?>
