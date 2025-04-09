<?php
require_once 'config.php';
require_once 'auth.php';
require_once 'films.php';

// Check if user is logged in and is an actor
if (!Auth::isLoggedIn() || Auth::getUserRole() !== 'actor') {
    header('Location: login.php');
    exit();
}

$filmManager = new FilmManager();
$actorId = $_SESSION['user_id'];

// Get actor details and films
$actorDetails = $filmManager->getActorDetails($actorId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord Acteur</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1>
        <nav>
            <a href="actor_dashboard.php">Mes Films</a>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>
    
    <main>
        <section class="profile-section">
            <h2>Mon Profil</h2>
            <p><strong>Nom:</strong> <?php echo htmlspecialchars($actorDetails['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($actorDetails['email']); ?></p>
            <p><strong>Date de naissance:</strong> <?php echo htmlspecialchars($actorDetails['birth_date']); ?></p>
            <p><strong>Nationalité:</strong> <?php echo htmlspecialchars($actorDetails['nationality']); ?></p>
        </section>
        
        <section class="films-list">
            <h2>Mes Films</h2>
            <?php if (!empty($actorDetails['films'])): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Année</th>
                            <th>Genre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($actorDetails['films'] as $film): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($film['title']); ?></td>
                            <td><?php echo htmlspecialchars($film['release_year']); ?></td>
                            <td><?php echo htmlspecialchars($film['genre']); ?></td>
                            <td>
                                <a href="film_detail.php?id=<?php echo $film['id']; ?>">Détails</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Vous n'êtes pas encore associé à des films.</p>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>