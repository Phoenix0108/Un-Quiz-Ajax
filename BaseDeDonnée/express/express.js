const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql2/promise');


const app = express();
const port = 3000;

//requêtes JSON
app.use(bodyParser.json());

// Configuration de la connexion à la base de données
const connection = mysql.createPool({
  host: '[]',
  user: 'root',
  password: '',
  database: '[]'
});

app.post('/repondre-question', async (req, res) => {
  try {
    const { id_question, id_qcm, reponse_utilisateur } = req.body;

    const [rows] = await connection.execute(
      'SELECT reponseTrue FROM question WHERE id = ? AND idqcm = ?',
      [id_question, id_qcm]
    );

    if (rows.length > 0 && rows[0].reponseTrue === reponse_utilisateur) {
      await connection.execute(
        'UPDATE note SET nbr_reponseTrue = nbr_reponseTrue + 1 WHERE idqcm = ?',
        [id_qcm]
      );
    }

    await connection.execute(
      'UPDATE note SET nbr_reponseRepondu = nbr_reponseRepondu + 1 WHERE idqcm = ?',
      [id_qcm]
    );


    res.json({ success: true, message: 'Réponse traitée avec succès.' });
  } catch (error) {
    console.error('Erreur lors du traitement de la réponse :', error.message);
    res.status(500).json({ success: false, message: 'Erreur serveur.' });
  }
});

// serveur
app.listen(port, () => {
  console.log(`Serveur Express écoutant sur le port ${port}`);
});
