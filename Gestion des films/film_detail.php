<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'films.php';
require_once 'comments.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$filmId = $_GET['id'];
$filmManager = new FilmManager();
$commentManager = new CommentManager();
$film = $filmManager->getFilmDetails($filmId);

if (!$film) {
    header('Location: index.php');
    exit();
}

// Handle comment deletion (for directors)
if (Auth::isLoggedIn() && Auth::getUserRole() === 'director' && isset($_GET['delete_comment'])) {
    $commentId = $_GET['delete_comment'];
    $directorId = Auth::getUserId();
    $commentManager->deleteComment($commentId, $directorId);
    header("Location: film_detail.php?id=$filmId");
    exit();
}

// Check if user can add comments (only fans)
$canAddComment = Auth::isLoggedIn() && Auth::getUserRole() === 'fan';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($film['title']); ?> - Détails</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($film['title']); ?></h1>
        <nav>
            <a href="<?php echo Auth::isLoggedIn() ? Auth::getUserRole() . '_dashboard.php' : 'index.php'; ?>">Retour</a>
            <?php if (Auth::isLoggedIn()): ?>
                <a href="logout.php">Déconnexion</a>
            <?php endif; ?>
        </nav>
    </header>
    
    <main>
        <section class="film-details">
            <h2>Détails du Film</h2>
            <p><strong>Réalisateur:</strong> <?php echo htmlspecialchars($film['director_name']); ?></p>
            <p><strong>Année de sortie:</strong> <?php echo htmlspecialchars($film['release_year']); ?></p>
            <p><strong>Genre:</strong> <?php echo htmlspecialchars($film['genre']); ?></p>
            <p><strong>Synopsis:</strong> <?php echo htmlspecialchars($film['synopsis']); ?></p>
            
            <h3>Acteurs</h3>
            <?php if (!empty($film['actors'])): ?>
                <ul>
                    <?php foreach ($film['actors'] as $actor): ?>
                    <li>
                        <a href="actor_detail.php?id=<?php echo $actor['id']; ?>">
                            <?php echo htmlspecialchars($actor['name']); ?>
                        </a>
                        (<?php echo htmlspecialchars($actor['nationality']); ?>)
                    </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucun acteur associé à ce film.</p>
            <?php endif; ?>
        </section>
        
        <section class="comments-section">
            <h3>Commentaires</h3>
            <?php if ($canAddComment): ?>
                <div class="add-comment">
                    <h4>Ajouter un commentaire</h4>
                    <form method="post" action="film_detail.php?id=<?php echo $filmId; ?>">
                        <input type="hidden" name="add_comment" value="1">
                        <input type="hidden" name="film_id" value="<?php echo $filmId; ?>">
                        <div class="form-group">
                            <label for="rating">Note (1-5):</label>
                            <input type="number" id="rating" name="rating" min="1" max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Commentaire:</label>
                            <textarea id="content" name="content" required></textarea>
                        </div>
                        <button type="submit">Soumettre</button>
                    </form>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($film['comments'])): ?>
                <div class="comments-list">
                    <?php foreach ($film['comments'] as $comment): ?>
                    <div class="comment">
                        <p><strong><?php echo htmlspecialchars($comment['fan_name']); ?></strong> 
                        (Note: <?php echo $comment['rating']; ?>/5)</p>
                        <p><?php echo htmlspecialchars($comment['content']); ?></p>
                        <p class="comment-date"><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></p>
                        <?php if (Auth::isLoggedIn() && Auth::getUserRole() === 'director' && $film['director_id'] == Auth::getUserId()): ?>
                            <a href="film_detail.php?id=<?php echo $filmId; ?>&delete_comment=<?php echo $comment['id']; ?>" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire?')">
                                Supprimer
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Aucun commentaire pour ce film.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>