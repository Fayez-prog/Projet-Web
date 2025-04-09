<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'films.php';
require_once 'comments.php';

// Check if user is logged in and is a fan
if (!Auth::isLoggedIn() || Auth::getUserRole() !== 'fan') {
    header('Location: login.php');
    exit();
}

$filmManager = new FilmManager();
$commentManager = new CommentManager();
$fanId = Auth::getUserId();

// Handle search
$search = $_GET['search'] ?? null;
$films = $filmManager->getAllFilms($search);

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_comment'])) {
    $content = $_POST['content'];
    $rating = $_POST['rating'];
    $filmId = $_POST['film_id'];
    $actorId = $_POST['actor_id'] ?? null;
    
    if ($commentManager->addComment($content, $rating, $filmId, $actorId, $fanId)) {
        header("Location: film_detail.php?id=$filmId&comment_success=1");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Fan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        <nav>
            <a href="fan_dashboard.php">Films</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    
    <main>
        <section class="search-section">
            <form method="get">
                <input type="text" name="search" placeholder="Rechercher par titre, genre ou acteur">
                <button type="submit">Rechercher</button>
            </form>
        </section>
        
        <section class="films-list">
            <h2>Tous les Films</h2>
            <?php if (!empty($films)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Année</th>
                            <th>Genre</th>
                            <th>Réalisateur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($films as $film): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($film['title']); ?></td>
                            <td><?php echo htmlspecialchars($film['release_year']); ?></td>
                            <td><?php echo htmlspecialchars($film['genre']); ?></td>
                            <td><?php echo htmlspecialchars($film['director_name']); ?></td>
                            <td>
                                <a href="film_detail.php?id=<?php echo $film['id']; ?>">Détails</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun film trouvé.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>