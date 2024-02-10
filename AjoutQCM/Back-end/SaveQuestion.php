<?php
//include "db_connect.php";
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
$question = htmlspecialchars($_POST["question"]);
$response1 = htmlspecialchars($_POST["reponse1"]);
$response2 = htmlspecialchars($_POST["reponse2"]);
$response3 = htmlspecialchars($_POST["reponse3"]);
$response4 = htmlspecialchars($_POST["reponse4"]);
$responseTrue = htmlspecialchars($_POST["reponseTrue"]);
/*
$request = $db->prepare("INSERT INTO QCM VALUES(?, ?, ?, ?, ?, ?)");
$request->bind_param("sssssi", $question, $response1, $response2, $response3, $response4, $responseTrue);
$request->execute();
$request->close();
$db->close();
*/
?>
