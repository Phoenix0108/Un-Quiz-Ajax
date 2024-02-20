# Système de Quizz - Schéma de Base de Données

Ce projet implémente un système de quizz avec une base de données MySQL. Le schéma de la base de données est décrit ci-dessous.

## Structure de la Base de Données

### Table Utilisateur

- `id` : Clé primaire auto-incrémentée.
- `nom` : Nom de l'utilisateur.
- `email` : Adresse e-mail de l'utilisateur (unique).
- `password` : Mot de passe haché de l'utilisateur.
- `token` : Jeton pour des fonctionnalités de sécurité supplémentaires.

### Table Question

- `id` : Clé primaire auto-incrémentée.
- `idqcm` : Clé étrangère faisant référence à l'identifiant du QCM auquel la question appartient.
- `question` : Texte de la question.
- `reponse1`, `reponse2`, `reponse3`, `reponse4` : Texte des options de réponse.
- `reponseTrue` : Indicateur (0 ou 1) indiquant quelle réponse est correcte.

### Table QCM

- `id` : Clé primaire auto-incrémentée.
- `id_user` : Clé étrangère faisant référence à l'identifiant de l'utilisateur qui a créé le QCM.
- `nom` : Nom du QCM.

## Instructions pour la Création de la Base de Données

1. Créez une base de données nommée `QUIZZ`.
2. Utilisez la base de données `QUIZZ`.
3. Exécutez les requêtes SQL suivantes pour créer les tables nécessaires :

```sql
CREATE TABLE utilisateur (
  id int primary key unique not null auto_increment,
  nom varchar(255) not null,
  email varchar(255) not null unique,
  password varchar(255) not null,
  token varchar(255)
);

CREATE TABLE question (
  id int primary key unique not null auto_increment,
  idqcm int not null,
  question varchar(255) not null,
  reponse1 varchar(255) not null,
  reponse2 varchar(255) not null,
  reponse3 varchar(255) not null,
  reponse4 varchar(255) not null,
  reponseTrue int not null
);

CREATE TABLE qcm (
  id int primary key not null unique auto_increment,
  id_user int not null,
  nom varchar(255) not null
);
