<?php
  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json");

  $reponse = file_get_contents('php://input');
  //on récupère les données du body reçu par la requete post

  $resultat = json_decode($reponse, true);
  //on décode le json en tableau associatif

  $data = ["message"=> $resultat["message"]];
  echo json_encode($data);
  //on renvoie la reponse encode en json de la valeur de le clé "message"
  //au serveur ExpressJs
?>