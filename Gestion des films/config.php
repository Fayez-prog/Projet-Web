<?php
// FILE: config.php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'film_management');
define('DB_USER', 'root');
define('DB_PASS', '');

// Établir la connexion
function getDBConnection() {
    try {
        $conn = new PDO(
            "mysql:host=".DB_HOST.";charset=utf8mb4",
            DB_USER, 
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );

        // Créer la base si elle n'existe pas
        $conn->exec("CREATE DATABASE IF NOT EXISTS `".DB_NAME."` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $conn->exec("USE `".DB_NAME."`");

        return $conn;
    } catch(PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}

// Initialisation de la structure de la base
function initDatabase($conn) {
    try {
        // Désactiver les contraintes FK temporairement
        $conn->exec("SET FOREIGN_KEY_CHECKS = 0");

        // Tables
        $conn->exec("DROP TABLE IF EXISTS FilmActors, Comments, Films, Actors, Users");

        $conn->exec("CREATE TABLE Users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('director', 'actor', 'fan') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            INDEX idx_role (role)
        )");

        $conn->exec("CREATE TABLE Actors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL UNIQUE,
            birth_date DATE NOT NULL,
            nationality VARCHAR(100),
            FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
        )");

        $conn->exec("CREATE TABLE Films (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL UNIQUE,
            synopsis TEXT,
            release_year INT NOT NULL,
            genre ENUM('Action', 'Drama', 'Comedy', 'Horror', 'Sci-Fi', 'Romance', 'Thriller', 'Other') NOT NULL,
            director_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (director_id) REFERENCES Users(id) ON DELETE CASCADE,
            CONSTRAINT chk_title CHECK (CHAR_LENGTH(title) >= 3),
            CONSTRAINT chk_synopsis CHECK (synopsis IS NULL OR CHAR_LENGTH(synopsis) >= 50),
            INDEX idx_director (director_id)
        )");

        $conn->exec("CREATE TABLE FilmActors (
            film_id INT NOT NULL,
            actor_id INT NOT NULL,
            PRIMARY KEY (film_id, actor_id),
            FOREIGN KEY (film_id) REFERENCES Films(id) ON DELETE CASCADE,
            FOREIGN KEY (actor_id) REFERENCES Actors(id) ON DELETE CASCADE
        )");

        $conn->exec("CREATE TABLE Comments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            content TEXT NOT NULL,
            rating INT NOT NULL,
            film_id INT,
            actor_id INT,
            fan_id INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (film_id) REFERENCES Films(id) ON DELETE SET NULL,
            FOREIGN KEY (actor_id) REFERENCES Actors(id) ON DELETE SET NULL,
            FOREIGN KEY (fan_id) REFERENCES Users(id) ON DELETE CASCADE,
            CONSTRAINT chk_rating CHECK (rating BETWEEN 1 AND 5)
        )");

        // Réactiver les contraintes FK
        $conn->exec("SET FOREIGN_KEY_CHECKS = 1");

        // Trigger pour valider l'année de sortie
        $conn->exec("DROP TRIGGER IF EXISTS validate_release_year");
        $conn->exec("CREATE TRIGGER validate_release_year
            BEFORE INSERT ON Films
            FOR EACH ROW
            BEGIN
                IF NEW.release_year < 2000 OR NEW.release_year > YEAR(CURDATE()) THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'L\'année doit être entre 2000 et l\'année courante';
                END IF;
            END");

        // Trigger pour valider que film_id ou actor_id est renseigné dans Comments
        $conn->exec("DROP TRIGGER IF EXISTS validate_comment_reference");
        $conn->exec("CREATE TRIGGER validate_comment_reference
            BEFORE INSERT ON Comments
            FOR EACH ROW
            BEGIN
                IF NEW.film_id IS NULL AND NEW.actor_id IS NULL THEN
                    SIGNAL SQLSTATE '45000'
                    SET MESSAGE_TEXT = 'Un commentaire doit être lié à un film ou un acteur.';
                END IF;
            END");

        // Insertion des données de test
        initSampleData($conn);

    } catch(PDOException $e) {
        die("Erreur d'initialisation : " . $e->getMessage());
    }
}

// Insertion des données de démonstration
function initSampleData($conn) {
    try {
        $conn->beginTransaction();
        
        // Vérifier si des données existent déjà
        $stmt = $conn->query("SELECT COUNT(*) FROM Users");
        if ($stmt->fetchColumn() > 0) {
            $conn->rollBack();
            return;
        }

        $passwords = [
            'director' => password_hash('Director123!', PASSWORD_BCRYPT),
            'actor' => password_hash('Actor123!', PASSWORD_BCRYPT),
            'fan' => password_hash('FanFilm123', PASSWORD_BCRYPT)
        ];

        $conn->exec("INSERT INTO Users (name, email, password, role) VALUES
            ('Luc Besson', 'luc.besson@example.com', '{$passwords['director']}', 'director'),
            ('Jean Dujardin', 'jean.dujardin@example.com', '{$passwords['actor']}', 'actor'),
            ('Cinema Fan', 'fan.cinema@example.com', '{$passwords['fan']}', 'fan')");

        $conn->exec("INSERT INTO Actors (user_id, birth_date, nationality) VALUES
            (2, '1972-06-19', 'Française'),
            (3, '1975-09-30', 'Française')");

        $conn->exec("INSERT INTO Films (title, synopsis, release_year, genre, director_id) VALUES
            ('Le Grand Bleu', 'Histoire d\'amitié et de compétition en plongée en apnée entre deux amis d\'enfance, Jacques et Enzo.', 2001, 'Drama', 1),
            ('OSS 117', 'Espionnage comique dans les années 60 mettant en scène l\'agent secret Hubert Bonisseur de La Bath dans des missions loufoques.', 2006, 'Comedy', 1),
            ('Un Prophète', 'Drame carcéral primé à Cannes suivant l\'ascension d\'un jeune détenu dans la hiérarchie de la prison.', 2009, 'Drama', 1)");

        $conn->exec("INSERT INTO FilmActors (film_id, actor_id) VALUES
            (1, 1), (2, 1), (3, 1)");

        $conn->exec("INSERT INTO Comments (content, rating, film_id, fan_id) VALUES
            ('Magnifique film sur l\'amitié et la passion de la plongée!', 5, 1, 3),
            ('Très drôle, Jean Dujardin est hilarant dans ce rôle!', 4, 2, 3),
            ('Acteurs exceptionnels et histoire captivante du début à la fin.', 5, 3, 3)");

        $conn->commit();
    } catch(PDOException $e) {
        $conn->rollBack();
        die("Erreur d'insertion des données : " . $e->getMessage());
    }
}

// Initialisation de la session
session_start();

// Connexion et initialisation
try {
    $db = getDBConnection();
    initDatabase($db);
} catch(PDOException $e) {
    die("Erreur d'initialisation : " . $e->getMessage());
}
?>