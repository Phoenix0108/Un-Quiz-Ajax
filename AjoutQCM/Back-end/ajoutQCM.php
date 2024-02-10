<?php
$allowOrigin = "http://localhost";
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html");
$numPage = htmlspecialchars($_POST["numPage"]);
$reponse = '<form class="form">
<h1>Créer un QCM</h1>
<p class="instruction">Veuillez cliquer sur le bouton radio à côté de la réponse correcte.</p>
<label for="question">Question :</label>
<input type="text" class="question" name="question" placeholder="Entrez votre question" required>

<label class="radio-label" for="r'.($numPage*4+1).'">
    <input type="radio" class="radio1" id="r'.($numPage*4+1).'" name="radioQCM'.($numPage+1).'" value="1">
    <span>Réponse 1 :</span>
</label>
<input type="text" class="reponse1" name="reponse1_text" placeholder="Entrez la réponse 1" required>

<label class="radio-label" for="r'.($numPage*4+2).'">
    <input type="radio" class="radio2" id="r'.($numPage*4+2).'" name="radioQCM'.($numPage+1).'" value="2">
    <span>Réponse 2 :</span>
</label>
<input type="text" class="reponse2" name="reponse2_text" placeholder="Entrez la réponse 2" required>

<label class="radio-label" for="r'.($numPage*4+3).'">
    <input type="radio" class="radio3" id="r'.($numPage*4+3).'" name="radioQCM'.($numPage+1).'" value="3">
    <span>Réponse 3 :</span>
</label>
<input type="text" class="reponse3" name="reponse3_text" placeholder="Entrez la réponse 3" required>

<label class="radio-label" for="r'.($numPage*4+4).'">
    <input type="radio" class="radio4" id="r'.($numPage*4+4).'" name="radioQCM'.($numPage+1).'" value="4">
    <span>Réponse 4 :</span>
</label>
<input type="text" class="reponse4" name="reponse4_text" placeholder="Entrez la réponse 4" required>

<div class="button-group">
    <button type="button" class="btn btnAdd">Ajouter une autre question</button>
</div>
</form>';
echo $reponse;
?>