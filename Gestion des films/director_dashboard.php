<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'films.php';
require_once 'actors.php';

// Vérification de l'authentification et du rôle
if (!Auth::isLoggedIn() || Auth::getUserRole() !== 'director') {
    header('Location: login.php');
    exit();
}

$filmManager = new FilmManager();
$actorManager = new ActorManager();
$directorId = Auth::getUserId();

// Gestion des soumissions de formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_film'])) {
        try {
            $filmManager->addFilm([
                'title' => $_POST['title'],
                'synopsis' => $_POST['synopsis'],
                'release_year' => $_POST['release_year'],
                'genre' => $_POST['genre'],
                'director_id' => $directorId
            ]);
            header('Location: director_dashboard.php');
            exit();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

// Récupération des films
$films = $filmManager->getFilmsByDirector($directorId, $_GET['search'] ?? null);
$actors = $actorManager->getAllActors();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Réalisateur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        <nav>
            <a href="director_dashboard.php">Mes Films</a>
            <a href="director_actors.php">Acteurs</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    
    <main>
        <section class="search-section">
            <form method="get">
                <input type="text" name="search" placeholder="Rechercher par titre, genre ou acteur">
                <button type="submit">Rechercher</button>
            </form>
            <button onclick="document.getElementById('addFilmModal').style.display='block'">Ajouter un film</button>
        </section>
        
        <section class="films-list">
            <h2>Mes Films</h2>
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Année</th>
                        <th>Genre</th>
                        <th>Acteurs</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($films as $film): ?>
        <tr>
            <td><?php echo htmlspecialchars($film['title'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($film['release_year'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($film['genre'] ?? ''); ?></td>
            <td><?php echo htmlspecialchars($film['actors'] ?? 'Aucun acteur'); ?></td>
            <td>
                <a href="film_detail.php?id=<?php echo $film['id']; ?>">Détails</a>
                <a href="edit_film.php?id=<?php echo $film['id']; ?>">Modifier</a>
                <a href="delete_film.php?id=<?php echo $film['id']; ?>" onclick="return confirm('Êtes-vous sûr?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
    
    <!-- Add Film Modal -->
    <div id="addFilmModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('addFilmModal').style.display='none'">&times;</span>
            <h2>Ajouter un nouveau film</h2>
            <form method="post" action="director_dashboard.php">
                <input type="hidden" name="add_film" value="1">
                <div class="form-group">
                    <label for="title">Titre*:</label>
                    <input type="text" id="title" name="title" required minlength="3">
                </div>
                <div class="form-group">
                    <label for="synopsis">Synopsis:</label>
                    <textarea id="synopsis" name="synopsis" minlength="50"></textarea>
                </div>
                <div class="form-group">
                    <label for="release_year">Année de sortie*:</label>
                    <input type="number" id="release_year" name="release_year" 
                           min="2000" max="<?php echo date('Y'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="genre">Genre*:</label>
                    <select id="genre" name="genre" required>
                        <option value="Action">Action</option>
                        <option value="Drama">Drame</option>
                        <option value="Comedy">Comédie</option>
                        <option value="Horror">Horreur</option>
                        <option value="Sci-Fi">Science-Fiction</option>
                        <option value="Romance">Romance</option>
                        <option value="Thriller">Thriller</option>
                        <option value="Other">Autre</option>
                    </select>
                </div>
                <button type="submit">Ajouter le film</button>
            </form>
        </div>
    </div>
    
    <script src="scripts.js"></script>
</body>
</html>