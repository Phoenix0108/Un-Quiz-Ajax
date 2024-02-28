<?php
function requeteExpress($route, $data){
    $opts = ['http'=>[
        "method"=>"POST",
        "header"=>"Content-Type: application/json",
        "content"=> json_encode($data)
    ]];
    $context = stream_context_create($opts);
    $reponse = file_get_contents('http://127.0.0.1:81/'.$route, false, $context);
    return json_decode($reponse, true);
}
?>