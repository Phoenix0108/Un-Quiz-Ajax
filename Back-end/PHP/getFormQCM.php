<?php
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");
$numPage = htmlspecialchars($_POST["nbrFormQCM"]);
$reponse = '<form class="form Column">
<p class="instruction">Veuillez cliquer sur le bouton radio à côté de la réponse correcte.</p>
<div class="Column cInput">
    <label for="question">Question :</label>
    <input type="text" class="question" name="question" placeholder="Entrez votre question"
        required>
</div>
<div class="Column cInput">
    <div class="Row">
        <input type="radio" id="r'.($numPage*4+1).'" name="r'.($numPage).'" value="1">
        <label for="r'.($numPage*4+1).'">Réponse 1 :</label>
    </div>
    <input type="text" class="reponse1" placeholder="Entrez la réponse 1" required>
</div>
<div class="Column cInput">
    <div class="Row">
        <input type="radio" id="r'.($numPage*4+2).'" name="r'.($numPage).'" value="2">
        <label for="r'.($numPage*4+2).'">Reponse 2:</label>
    </div>
    <input type="text" class="reponse2" placeholder="Entrez la réponse 2" required>
</div>
<div class="Column cInput">
    <div class="Row">
        <input type="radio" id="r'.($numPage*4+3).'" name="r'.($numPage).'" value="3">
        <label for="r'.($numPage*4+3).'">Reponse 3:</label>
    </div>
    <input type="text" class="reponse3" placeholder="Entrez la réponse 3" required>
</div>
<div class="Column cInput">
    <div class="Row">
        <input type="radio" id="r'.($numPage*4+4).'" name="r'.($numPage).'" value="4">
        <label for="r'.($numPage*4+4).'">Reponse 4:</label>
    </div>
    <input type="text" class="reponse4" placeholder="Entrez la réponse 4" required>
</div>
</form>';
echo $reponse;
?>