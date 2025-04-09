<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'films.php';

// Vérification de l'authentification et du rôle
if (!Auth::isLoggedIn() || Auth::getUserRole() !== 'director') {
    header('Location: login.php');
    exit();
}

$filmManager = new FilmManager();
$directorId = Auth::getUserId();

// Vérifier si l'ID du film est présent et appartient au réalisateur
if (!isset($_GET['id'])) {
    header('Location: director_dashboard.php');
    exit();
}

$filmId = $_GET['id'];
$film = $filmManager->getFilmById($filmId);

if (!$film || $film['director_id'] != $directorId) {
    header('Location: director_dashboard.php');
    exit();
}

// Traitement de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $filmManager->deleteFilm($filmId);
        header('Location: director_dashboard.php');
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer le film</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Supprimer le film</h1>
        <nav>
            <a href="director_dashboard.php">Retour au tableau de bord</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    
    <main>
        <section class="delete-film-confirm">
            <h2>Confirmation de suppression</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <p>Êtes-vous sûr de vouloir supprimer le film "<?php echo htmlspecialchars($film['title']); ?>" ?</p>
            <p>Cette action est irréversible.</p>
            
            <form method="post">
                <button type="submit" class="delete-btn">Confirmer la suppression</button>
                <a href="director_dashboard.php" class="cancel-btn">Annuler</a>
            </form>
        </section>
    </main>
    
    <script src="scripts.js"></script>
</body>
</html>