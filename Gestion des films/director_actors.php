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

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_actor'])) {
        try {
            $actorId = $_POST['actor_id'];
    $filmId = $_POST['film_id'];
    
    if ($filmManager->addActorToFilm($filmId, $actorId, $directorId)) {
        $_SESSION['success'] = "Acteur ajouté avec succès";
    } else {
        $_SESSION['error'] = "Erreur lors de l'ajout";
    }
    header("Location: director_actors.php");
    exit();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: director_actors.php');
            exit();
        }
    } elseif (isset($_POST['remove_actor'])) {
        try {
            $actorId = $_POST['actor_id'];
            $filmId = $_POST['film_id'];
            
            if ($filmManager->removeActorFromFilm($filmId, $actorId, $directorId)) {
                $_SESSION['success'] = "Acteur retiré du film avec succès";
            } else {
                $_SESSION['error'] = "Erreur lors du retrait de l'acteur";
            }
            header('Location: director_actors.php');
            exit();
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: director_actors.php');
            exit();
        }
    }
}


// Récupération des données
$films = $filmManager->getFilmsByDirector($directorId);
$allActors = $actorManager->getAllActors();
$availableActors = $actorManager->getAvailableActorsForDirector($directorId);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Acteurs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Gestion des Acteurs - <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?></h1>
        <nav>
            <a href="director_dashboard.php">Mes Films</a>
            <a href="director_actors.php">Acteurs</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>

    <main>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <section class="films-actors">
            <h2>Mes Films et leurs Acteurs</h2>
            
            <?php foreach ($films as $film): ?>
            <div class="film-card">
                <h3><?php echo htmlspecialchars($film['title'] ?? ''); ?> (<?php echo htmlspecialchars($film['release_year'] ?? ''); ?>)</h3>
                <p>Genre: <?php echo htmlspecialchars($film['genre'] ?? ''); ?></p>
                
                <h4>Acteurs:</h4>
                <?php if (!empty($film['actors'])): ?>
                    <ul>
                        <?php foreach (explode(', ', $film['actors']) as $actor): ?>
                        <li>
                            <?php echo htmlspecialchars($actor); ?>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="film_id" value="<?php echo $film['id']; ?>">
                                <input type="hidden" name="actor_id" value="<?php 
                                    echo $actorManager->getActorIdByName($actor); 
                                ?>">
                                <button type="submit" name="remove_actor" class="btn-small">Retirer</button>
                            </form>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucun acteur pour ce film</p>
                <?php endif; ?>
                
                <!-- Formulaire pour ajouter un acteur -->
                <form method="post" class="add-actor-form">
                    <input type="hidden" name="film_id" value="<?php echo $film['id']; ?>">
                    <select name="actor_id" required>
    <option value="">Sélectionner un acteur</option>
    <?php foreach ($availableActors as $actor): ?>
        <option value="<?= $actor['id'] ?>">
            <?= htmlspecialchars($actor['name']) ?>
            (<?= htmlspecialchars($actor['nationality']) ?>)
        </option>
    <?php endforeach; ?>
</select>
                    <button type="submit" name="add_actor" class="btn-small">Ajouter</button>
                </form>
            </div>
            <?php endforeach; ?>
        </section>

        <section class="all-actors">
            <h2>Tous les Acteurs Disponibles</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Date de Naissance</th>
                        <th>Nationalité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allActors as $actor): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($actor['name'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($actor['birth_date'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($actor['nationality'] ?? ''); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="scripts.js"></script>
</body>
</html>