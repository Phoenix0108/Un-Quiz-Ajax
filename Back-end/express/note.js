const mysql = require('mysql2/promise');

const connection = mysql.createPool({
  host: '[]',
  user: 'root',
  password: '',
  database: '[]'
});

async function createNoteTable() {
  try {
    const sql = `
      CREATE TABLE note (
        id INT NOT NULL UNIQUE PRIMARY KEY AUTO_INCREMENT,
        id_user INT NOT NULL,
        idqcm INT NOT NULL,
        nbr_reponseRepondu INT NOT NULL,
        nbr_reponseTrue INT NOT NULL,
        en_cours INT NOT NULL,
        date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
      )
    `;

    const [rows, fields] = await connection.execute(sql);
    console.log('Table "note" créée avec succès.');
  } catch (error) {
    console.error('Erreur lors de la création de la table "note":', error.message);
  } finally {
    // Fermer la connexion après l'opération
    await connection.end();
  }
}

createNoteTable();
