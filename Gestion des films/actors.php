<?php
require_once 'config.php';

class ActorManager {
    private $db;
    
    public function __construct() {
        $this->db = getDBConnection();
    }

    
    // Add a new actor (called by director)
    public function addActor($name, $email, $password, $birthDate, $nationality) {
        $auth = new Auth();
        $actorData = [
            'birth_date' => $birthDate,
            'nationality' => $nationality
        ];
        return $auth->register($name, $email, $password, 'actor', $actorData);
    }
    
    // Update actor information
    public function updateActor($actorId, $name, $birthDate, $nationality) {
        try {
            $this->db->beginTransaction();
            
            // Update user info
            $stmt = $this->db->prepare("UPDATE Users SET name = ? WHERE id = (SELECT user_id FROM Actors WHERE id = ?)");
            $stmt->execute([$name, $actorId]);
            
            // Update actor info
            $stmt = $this->db->prepare("UPDATE Actors SET birth_date = ?, nationality = ? WHERE id = ?");
            $stmt->execute([$birthDate, $nationality, $actorId]);
            
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    
    // Get actors by film
    public function getActorsByFilm($filmId) {
        $stmt = $this->db->prepare("SELECT a.id, u.name, a.birth_date, a.nationality 
                                   FROM FilmActors fa
                                   JOIN Actors a ON fa.actor_id = a.id
                                   JOIN Users u ON a.user_id = u.id
                                   WHERE fa.film_id = ?");
        $stmt->execute([$filmId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get all actors
    public function getAllActors() {
        $stmt = $this->db->prepare("SELECT a.id, u.name, a.birth_date, a.nationality,
                                   COUNT(fa.film_id) as film_count
                                   FROM Actors a
                                   JOIN Users u ON a.user_id = u.id
                                   LEFT JOIN FilmActors fa ON a.id = fa.actor_id
                                   GROUP BY a.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get actor details
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

       // Add this method to your ActorManager class in actors.php
// Ajoutez ces méthodes à votre classe ActorManager
public function getAvailableActorsForDirector($directorId) {
    $sql = "SELECT a.id, u.name, a.birth_date, a.nationality
            FROM Actors a
            JOIN Users u ON a.user_id = u.id
            WHERE a.id NOT IN (
                SELECT fa.actor_id 
                FROM FilmActors fa
                JOIN Films f ON fa.film_id = f.id
                WHERE f.director_id = :director_id
            )";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':director_id', $directorId);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getActorIdByName($name) {
    $stmt = $this->db->prepare("SELECT a.id FROM Actors a JOIN Users u ON a.user_id = u.id WHERE u.name = ?");
    $stmt->execute([$name]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['id'] : null;
}
}
?>