## Tables Créées
1. **Utilisateur (User):**
   - UserID (Clé primaire)
   - Nom d'utilisateur
   - Email
   - Mot de passe (haché)

2. **QCM:**
   - QCMID (Clé primaire)
   - Titre
   - Code d'accès (peut être généré automatiquement)
   - UserID (Clé étrangère faisant référence à la table Utilisateur pour savoir quel utilisateur a créé ce QCM)
   - Évaluation activée (Booléen indiquant si l'évaluation est activée ou non)

3. **Question:**
   - QuestionID (Clé primaire)
   - Texte de la question
   - QCMID (Clé étrangère faisant référence à la table QCM à laquelle cette question appartient)

4. **Reponse:**
   - ReponseID (Clé primaire)
   - Texte de la réponse
   - EstCorrecte (Booléen indiquant si la réponse est correcte ou non)
   - QuestionID (Clé étrangère faisant référence à la table Question à laquelle cette réponse appartient)

5. **NoteUtilisateurQCM:**
   - NoteID (Clé primaire)
   - UserID (Clé étrangère faisant référence à la table Utilisateur pour savoir quel utilisateur a répondu au QCM)
   - QCMID (Clé étrangère faisant référence à la table QCM pour savoir à quel QCM cette note appartient)
   - Note (La note attribuée à l'utilisateur pour ce QCM)

