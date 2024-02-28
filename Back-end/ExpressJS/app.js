const initDB = require('./db_connect');
const connection = initDB();

const express = require("express");

const app = express();

app.use(express.json());

app.post("/saveState", (req, res) => {
    const body = req.body;
    const query = "INSERT INTO note(id_user, idqcm, nbr_reponseRepondu, nbr_reponseTrue, en_cours) VALUES(?, ?, ?, ?, ?)";
    value = [body.id_user, body.idqcm, 1, 1, 0];
    if(body.reponse){
        //On détermine si la reponse est vraie
        value[3] = 1;
    }else{
        value[3] = 0;
    }
    if(body.numQuestionTotal == 1){
        //On détermine si le QCM est fini (0) ou pas (1)
        value[4] = 0;
    }else{
        value[4] = 1;
    }
    connection.execute(query, value, (err, result) => {
        if(err){
            console.log(err);
            //res.json({'state': false});
        }else{
            console.log("requete reussi");
            //res.json({'state': true});
        }
        res.send();
    });
});

app.post("/getProgression", (req, res) => {
    const body = req.body;
    query = "SELECT * FROM note WHERE idqcm = ? AND id_user = ?";
    value = [body.idqcm, body.id_user];
    if(body.id_note){
        query = "SELECT * FROM note WHERE idqcm = ? AND id_user = ? AND id = ?";
        value = [body.idqcm, body.id_user, body.id_note];
    }
    connection.execute(query, value, (err, result)=>{
        if(err){
            console.log(err);
        }else{
            console.log("requete reussi");
            res.json(result[result.length-1]);
        }
    });
});

app.post("/updateProgression", (req, res)=>{
    const body = req.body;
    const query = "UPDATE note set nbr_reponseTrue = ?, nbr_reponseRepondu = ?, en_cours = ? WHERE id = ?";
    value = [body.reponseTrue, body.reponseRepondu, body.en_cours, body.id];
    connection.execute(query, value, (err, result)=>{
        if(err){
            console.log(err);
        }else{
            console.log("requete reussi");
            res.send();
        }
    });

});

app.post("/getNote", (req, res)=>{
    const body = req.body;
    const query = "SELECT * FROM note WHERE id_user = ?";
    const value = [body.id_user];
    connection.execute(query, value, (err, result)=>{
        if(err){
            console.log(err);
            res.send();
        }else{
            res.json(result);
        }
    });
});

app.post("/supNote", (req, res)=>{
    const body = req.body;
    const query = "DELETE FROM note WHERE id = ? AND id_user = ?";
    const value = [body.id_note, body.id_user];
    connection.execute(query, value, (err, result)=>{
        if(err){
            console.log(err);
        }else{
            console.log("requete reussi");
        }
        res.send();
    });
});

app.listen(81, () => {
    console.log("Server running");
})