const express = require("express");
const cors = require("cors");

const app = express();
app.use(cors());
app.use(express.json());
//app.use(express.urlencoded({ extended: true }));
//pas besoin de decode en x-www-form-urlencoded comme le body est codé en json

app.post("/express", (req, res) => {
    data = req.body;

    res.json({ "message": data.message });
    //on revoie la reponse au serveur PHP
});

app.listen(81, () => {
    console.log("server running");
});