const express = require("express");
const cors = require("cors");
var XMLHttpRequest = require('xhr2');
var xhr = new XMLHttpRequest();

const app = express();

app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
//Permet à express de comprendre le conntent-type en x-www-form-urlencoded

app.post("/express", (req, res) => {
    xhr.open("POST", "http://127.0.0.1/index.php");
    //ouvre une requête POST au serveur PHP

    xhr.responseType = "json";
    //Précise que la réponse doit être en json

    xhr.setRequestHeader('Content-Type', 'application/json');
    //précise que le contenue qui est envoyer est en json

    //xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    //précise que le contenue qui est envoyer est en x-www-form-urlendoded

    const body = JSON.stringify({ "message": req.body.message });
    //encode en json

    xhr.send(body);
    //envoie la requete au serveur php avec le contenue

    xhr.onload = () => {
        //gère l'état de la connection
        if (xhr.readyState === 4 && xhr.status === 200) {
            // readyState = 4 signifie que l'échange est terminé
            //xhr.status = 200 veut dire que la connection avec le serveur est correcte
            res.json(xhr.response);
            //un envoie la réponse au Front-end
        } else {

        }
    };
});

app.listen(81, () => {
    console.log("server running");
});