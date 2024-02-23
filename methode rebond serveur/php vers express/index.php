<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json");

  /*$postdata = http_build_query([
    'name' => 'Robert',
    'id' => '1'
  ]);*/
  //http_build_query pour encode en x-www-form-urlencoded

  $data = json_encode(["message"=>"express reussi"]);
  //sinon en json

  $opts = ['http' => [
    'method' => 'POST',
    //'header' => 'Content-type: application/x-www-form-urlencoded',
    // le header pour encoderen x-www-form-urlencoded
    'header' => 'Content-type: application/json',
    //sinon en json
    'content' => $data
  ]];
  $context = stream_context_create($opts);
  $reponse = file_get_contents('http://127.0.0.1:81/express', false, $context);
  //on envoie le requete au serveur ExpressJS avec des données dans le body
  //et on reçoit le réponse en return

  $resultat = json_decode($reponse, true);
  //Puis on décode le json dans un tableau associatif

  $data = ["message"=> $resultat["message"]];
  echo json_encode($data);
  //on revoie le reponse au front-end en json
?>