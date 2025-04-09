<?php
require_once 'config.php';

class CommentManager {
    private $db;
    
    public function __construct() {
        $this->db = getDBConnection();
    }
    
    // Add a comment (for fans)
    public function addComment($content, $rating, $filmId, $actorId, $fanId) {
        // Validate that either filmId or actorId is provided
        if (!$filmId && !$actorId) {
            return false;
        }
        
        $stmt = $this->db->prepare("INSERT INTO Comments (content, rating, film_id, actor_id, fan_id) 
                                   VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$content, $rating, $filmId, $actorId, $fanId]);
    }
    
    // Delete a comment (for directors)
    public function deleteComment($commentId, $directorId) {
        // Verify the comment is on a film the director owns
        $stmt = $this->db->prepare("DELETE c FROM Comments c
                                   JOIN Films f ON c.film_id = f.id
                                   WHERE c.id = ? AND f.director_id = ?");
        return $stmt->execute([$commentId, $directorId]);
    }
    
    // Get comments for a film
    public function getFilmComments($filmId) {
        $stmt = $this->db->prepare("SELECT c.*, u.name as fan_name 
                                   FROM Comments c
                                   JOIN Users u ON c.fan_id = u.id
                                   WHERE c.film_id = ?
                                   ORDER BY c.created_at DESC");
        $stmt->execute([$filmId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get comments for an actor
    public function getActorComments($actorId) {
        $stmt = $this->db->prepare("SELECT c.*, u.name as fan_name 
                                   FROM Comments c
                                   JOIN Users u ON c.fan_id = u.id
                                   WHERE c.actor_id = ?
                                   ORDER BY c.created_at DESC");
        $stmt->execute([$actorId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>