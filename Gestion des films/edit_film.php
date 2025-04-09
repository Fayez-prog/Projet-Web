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

// Traitement de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $filmManager->updateFilm($filmId, [
            'title' => $_POST['title'],
            'synopsis' => $_POST['synopsis'],
            'release_year' => $_POST['release_year'],
            'genre' => $_POST['genre']
        ]);
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
    <title>Modifier le film</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Modifier le film</h1>
        <nav>
            <a href="director_dashboard.php">Retour au tableau de bord</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    
    <main>
        <section class="edit-film-form">
            <h2><?php echo htmlspecialchars($film['title']); ?></h2>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="title">Titre*:</label>
                    <input type="text" id="title" name="title" 
                           value="<?php echo htmlspecialchars($film['title']); ?>" required minlength="3">
                </div>
                <div class="form-group">
                    <label for="synopsis">Synopsis:</label>
                    <textarea id="synopsis" name="synopsis" minlength="50"><?php 
                        echo htmlspecialchars($film['synopsis']); 
                    ?></textarea>
                </div>
                <div class="form-group">
                    <label for="release_year">Année de sortie*:</label>
                    <input type="number" id="release_year" name="release_year" 
                           value="<?php echo htmlspecialchars($film['release_year']); ?>" 
                           min="2000" max="<?php echo date('Y'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="genre">Genre*:</label>
                    <select id="genre" name="genre" required>
                        <option value="Action" <?php echo $film['genre'] === 'Action' ? 'selected' : ''; ?>>Action</option>
                        <option value="Drama" <?php echo $film['genre'] === 'Drama' ? 'selected' : ''; ?>>Drame</option>
                        <option value="Comedy" <?php echo $film['genre'] === 'Comedy' ? 'selected' : ''; ?>>Comédie</option>
                        <option value="Horror" <?php echo $film['genre'] === 'Horror' ? 'selected' : ''; ?>>Horreur</option>
                        <option value="Sci-Fi" <?php echo $film['genre'] === 'Sci-Fi' ? 'selected' : ''; ?>>Science-Fiction</option>
                        <option value="Romance" <?php echo $film['genre'] === 'Romance' ? 'selected' : ''; ?>>Romance</option>
                        <option value="Thriller" <?php echo $film['genre'] === 'Thriller' ? 'selected' : ''; ?>>Thriller</option>
                        <option value="Other" <?php echo $film['genre'] === 'Other' ? 'selected' : ''; ?>>Autre</option>
                    </select>
                </div>
                <button type="submit">Enregistrer les modifications</button>
                <a href="director_dashboard.php" class="cancel-btn">Annuler</a>
            </form>
        </section>
    </main>
    
    <script src="scripts.js"></script>
</body>
</html>
