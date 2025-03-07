CREATE DATABASE quizz_db;
USE quizz_db;

-- Table pour stocker les quiz
CREATE TABLE Quizz (
    id_quizz INT AUTO_INCREMENT PRIMARY KEY,
    nom_quizz VARCHAR(255) NOT NULL
);

-- Table pour stocker les catégories de questions
CREATE TABLE Categorie (
    id_cat INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

-- Table pour stocker les questions
CREATE TABLE Question (
    id INT AUTO_INCREMENT PRIMARY KEY,
    intitule TEXT NOT NULL,
    question_multiple BOOLEAN DEFAULT FALSE,
    difficulte ENUM('facile', 'moyen', 'difficile') NOT NULL,
    id_cat INT,
    FOREIGN KEY (id_cat) REFERENCES Categorie(id_cat) 
);

-- Table pour stocker les réponses possibles
CREATE TABLE Reponses (
    id_reponse INT AUTO_INCREMENT PRIMARY KEY,
    intitule TEXT NOT NULL,
    id_question INT NOT NULL,
    est_correct BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_question) REFERENCES Question(id) 
);

-- Table pour stocker les réponses aléatoires
CREATE TABLE Reponse_aleatoire (
    id_reponse_random INT AUTO_INCREMENT PRIMARY KEY,
    intitule TEXT NOT NULL,
    id_question INT NOT NULL,
    FOREIGN KEY (id_question) REFERENCES Question(id) 
);


INSERT INTO Quizz (nom_quizz) VALUES ('Quiz Culture Générale'), ('Quiz Informatique');

INSERT INTO Categorie (nom) VALUES ('Histoire'), ('Science'), ('Informatique');

INSERT INTO Question (intitule, question_multiple, difficulte, id_cat) 
VALUES 
('Quelle est la capitale de la France ?', FALSE, 'facile', 1),
('Quelle est la planète la plus proche du Soleil ?', FALSE, 'facile', 2),
('Qui a inventé le langage C ?', FALSE, 'moyen', 3);

INSERT INTO Reponses (intitule, id_question, est_correct) 
VALUES 
('Paris', 1, TRUE),
('Londres', 1, FALSE),
('Mercure', 2, TRUE),
('Vénus', 2, FALSE),
('Dennis Ritchie', 3, TRUE),
('Linus Torvalds', 3, FALSE);
