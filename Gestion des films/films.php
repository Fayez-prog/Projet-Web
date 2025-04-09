<?php
require_once 'config.php';
require_once 'actors.php';

class FilmManager {
    private $db;
    
    public function __construct() {
        $this->db = getDBConnection();
    }
    
    // Add a new film
    public function addFilm($title, $synopsis, $releaseYear, $genre, $directorId) {
        try {
            $stmt = $this->db->prepare("INSERT INTO Films (title, synopsis, release_year, genre, director_id) 
                                     VALUES (:title, :synopsis, :release_year, :genre, :director_id)");
            return $stmt->execute([
                ':title' => $title,
                ':synopsis' => $synopsis,
                ':release_year' => $releaseYear,
                ':genre' => $genre,
                ':director_id' => $directorId
            ]);
        } catch (PDOException $e) {
            error_log("Error adding film: " . $e->getMessage());
            return false;
        }
    }
    
    // Update a film
    public function updateFilm($filmId, $title, $synopsis, $releaseYear, $genre, $directorId) {
        try {
            $stmt = $this->db->prepare("UPDATE Films SET 
                                      title = :title, 
                                      synopsis = :synopsis, 
                                      release_year = :release_year, 
                                      genre = :genre 
                                      WHERE id = :id AND director_id = :director_id");
            return $stmt->execute([
                ':title' => $title,
                ':synopsis' => $synopsis,
                ':release_year' => $releaseYear,
                ':genre' => $genre,
                ':id' => $filmId,
                ':director_id' => $directorId
            ]);
        } catch (PDOException $e) {
            error_log("Error updating film: " . $e->getMessage());
            return false;
        }
    }
    
    // Delete a film
    public function deleteFilm($filmId, $directorId) {
        try {
            $this->db->beginTransaction();
            
            // First delete from FilmActors
            $stmt = $this->db->prepare("DELETE FROM FilmActors WHERE film_id = :film_id");
            $stmt->execute([':film_id' => $filmId]);
            
            // Then delete from Comments
            $stmt = $this->db->prepare("DELETE FROM Comments WHERE film_id = :film_id");
            $stmt->execute([':film_id' => $filmId]);
            
            // Finally delete the film
            $stmt = $this->db->prepare("DELETE FROM Films WHERE id = :id AND director_id = :director_id");
            $result = $stmt->execute([
                ':id' => $filmId,
                ':director_id' => $directorId
            ]);
            
            $this->db->commit();
            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error deleting film: " . $e->getMessage());
            return false;
        }
    }
    
    // Get films by director with optional search
    public function getFilmsByDirector($directorId, $search = null) {
        try {
            $sql = "SELECT f.id, f.title, f.release_year, f.genre, 
                    GROUP_CONCAT(u.name SEPARATOR ', ') as actors
                    FROM Films f
                    LEFT JOIN FilmActors fa ON f.id = fa.film_id
                    LEFT JOIN Actors a ON fa.actor_id = a.id
                    LEFT JOIN Users u ON a.user_id = u.id
                    WHERE f.director_id = :director_id";
            
            $params = [':director_id' => $directorId];
            
            if ($search) {
                $sql .= " AND (f.title LIKE :search OR f.genre LIKE :search OR u.name LIKE :search)";
                $params[':search'] = "%$search%";
            }
            
            $sql .= " GROUP BY f.id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting films by director: " . $e->getMessage());
            return [];
        }
    }
    
    // Get film details with actors and comments
    public function getFilmDetails($filmId) {
        try {
            // Get basic film info
            $stmt = $this->db->prepare("SELECT f.*, u.name as director_name 
                                     FROM Films f 
                                     JOIN Users u ON f.director_id = u.id 
                                     WHERE f.id = :id");
            $stmt->execute([':id' => $filmId]);
            $film = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$film) {
                return null;
            }
            
            // Get actors
            $stmt = $this->db->prepare("SELECT a.id, u.name, a.birth_date, a.nationality 
                                     FROM FilmActors fa
                                     JOIN Actors a ON fa.actor_id = a.id
                                     JOIN Users u ON a.user_id = u.id
                                     WHERE fa.film_id = :film_id");
            $stmt->execute([':film_id' => $filmId]);
            $film['actors'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Get comments with average rating
            $stmt = $this->db->prepare("SELECT c.*, u.name as fan_name 
                                     FROM Comments c
                                     JOIN Users u ON c.fan_id = u.id
                                     WHERE c.film_id = :film_id
                                     ORDER BY c.created_at DESC");
            $stmt->execute([':film_id' => $filmId]);
            $film['comments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Calculate average rating
            $film['average_rating'] = array_reduce($film['comments'], function($carry, $comment) {
                return $carry + $comment['rating'];
            }, 0) / (count($film['comments']) ?: 1);
            
            return $film;
        } catch (PDOException $e) {
            error_log("Error getting film details: " . $e->getMessage());
            return null;
        }
    }
    
    // Add actor to film with verification
    public function addActorToFilm($filmId, $actorId, $directorId) {
        try {
            $this->db->beginTransaction();
            
            // Verify the film belongs to the director
            $stmt = $this->db->prepare("SELECT id FROM Films WHERE id = :film_id AND director_id = :director_id");
            $stmt->execute([
                ':film_id' => $filmId,
                ':director_id' => $directorId
            ]);
            
            if (!$stmt->fetch()) {
                $this->db->rollBack();
                return false;
            }
            
            // Check if actor already exists in film
            $stmt = $this->db->prepare("SELECT 1 FROM FilmActors WHERE film_id = :film_id AND actor_id = :actor_id");
            $stmt->execute([
                ':film_id' => $filmId,
                ':actor_id' => $actorId
            ]);
            
            if ($stmt->fetch()) {
                $this->db->rollBack();
                return false; // Actor already in film
            }
            
            // Add actor to film
            $stmt = $this->db->prepare("INSERT INTO FilmActors (film_id, actor_id) VALUES (:film_id, :actor_id)");
            $result = $stmt->execute([
                ':film_id' => $filmId,
                ':actor_id' => $actorId
            ]);
            
            $this->db->commit();
            return $result;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Error adding actor to film: " . $e->getMessage());
            return false;
        }
    }
    
    // Remove actor from film
    public function removeActorFromFilm($filmId, $actorId, $directorId) {
        try {
            // Verify the film belongs to the director
            $stmt = $this->db->prepare("SELECT id FROM Films WHERE id = :film_id AND director_id = :director_id");
            $stmt->execute([
                ':film_id' => $filmId,
                ':director_id' => $directorId
            ]);
            
            if (!$stmt->fetch()) {
                return false;
            }
            
            $stmt = $this->db->prepare("DELETE FROM FilmActors WHERE film_id = :film_id AND actor_id = :actor_id");
            return $stmt->execute([
                ':film_id' => $filmId,
                ':actor_id' => $actorId
            ]);
        } catch (PDOException $e) {
            error_log("Error removing actor from film: " . $e->getMessage());
            return false;
        }
    }

        // Ajoutez cette méthode pour obtenir les détails d'un acteur
        public function getActorDetails($actorId) {
            $stmt = $this->db->prepare("SELECT a.*, u.name, u.email 
                                      FROM Actors a
                                      JOIN Users u ON a.user_id = u.id
                                      WHERE a.id = ?");
            $stmt->execute([$actorId]);
            $actor = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($actor) {
                // Get films
                $stmt = $this->db->prepare("SELECT f.id, f.title, f.release_year, f.genre 
                                           FROM FilmActors fa
                                           JOIN Films f ON fa.film_id = f.id
                                           WHERE fa.actor_id = ?");
                $stmt->execute([$actorId]);
                $actor['films'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Get comments
                $stmt = $this->db->prepare("SELECT c.*, u.name as fan_name 
                                           FROM Comments c
                                           JOIN Users u ON c.fan_id = u.id
                                           WHERE c.actor_id = ?
                                           ORDER BY c.created_at DESC");
                $stmt->execute([$actorId]);
                $actor['comments'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return $actor;
        }
    
        // Ajoutez cette méthode pour obtenir tous les films (pour le tableau de bord fan)
        public function getAllFilms($search = null) {
            $sql = "SELECT f.*, u.name as director_name 
                    FROM Films f
                    JOIN Users u ON f.director_id = u.id";
            
            if ($search) {
                $sql .= " WHERE f.title LIKE :search 
                          OR f.genre LIKE :search
                          OR f.id IN (
                              SELECT fa.film_id 
                              FROM FilmActors fa
                              JOIN Actors a ON fa.actor_id = a.id
                              JOIN Users u ON a.user_id = u.id
                              WHERE u.name LIKE :search
                          )";
            }
            
            $stmt = $this->db->prepare($sql);
            
            if ($search) {
                $searchTerm = "%$search%";
                $stmt->bindParam(':search', $searchTerm);
            }
            
            $stmt->execute();
            $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Pour chaque film, récupérer les acteurs
            foreach ($films as &$film) {
                $stmt = $this->db->prepare("SELECT a.id, u.name 
                                           FROM FilmActors fa
                                           JOIN Actors a ON fa.actor_id = a.id
                                           JOIN Users u ON a.user_id = u.id
                                           WHERE fa.film_id = ?");
                $stmt->execute([$film['id']]);
                $film['actors'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return $films;
        }

        public function getFilmById($filmId) {
            // Utilisation d'une requête SQL pour récupérer un film par son ID
            $query = "SELECT * FROM films WHERE id = :filmId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':filmId', $filmId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Récupère le film si trouvé, sinon retourne null
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
}