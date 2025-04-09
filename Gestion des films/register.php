<?php
require_once 'config.php';
require_once 'auth.php';

$auth = new Auth();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $role = $_POST['role'];
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "Tous les champs sont obligatoires";
    } elseif ($password !== $confirmPassword) {
        $error = "Les mots de passe ne correspondent pas";
    } else {
        // Additional data for actors
        $actorData = null;
        if ($role === 'actor') {
            $actorData = [
                'birth_date' => $_POST['birth_date'],
                'nationality' => $_POST['nationality']
            ];
        }
        
        if ($auth->register($name, $email, $password, $role, $actorData)) {
            $success = "Inscription réussie! Vous pouvez maintenant vous connecter.";
        } else {
            $error = "L'inscription a échoué. L'email est peut-être déjà utilisé.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="auth-container">
        <h1>Inscription</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="name">Nom complet:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle:</label>
                <select id="role" name="role" required onchange="toggleActorFields()">
                    <option value="fan">Fan</option>
                    <option value="director">Réalisateur</option>
                    <option value="actor">Acteur</option>
                </select>
            </div>
            
            <!-- Actor-specific fields (hidden by default) -->
            <div id="actor-fields" style="display: none;">
                <div class="form-group">
                    <label for="birth_date">Date de naissance:</label>
                    <input type="date" id="birth_date" name="birth_date">
                </div>
                <div class="form-group">
                    <label for="nationality">Nationalité:</label>
                    <input type="text" id="nationality" name="nationality">
                </div>
            </div>
            
            <button type="submit">S'inscrire</button>
        </form>
        <p>Déjà un compte? <a href="login.php">Se connecter</a></p>
    </div>
    
    <script>
        function toggleActorFields() {
            const role = document.getElementById('role').value;
            const actorFields = document.getElementById('actor-fields');
            
            if (role === 'actor') {
                actorFields.style.display = 'block';
                // Make fields required
                document.getElementById('birth_date').required = true;
                document.getElementById('nationality').required = true;
            } else {
                actorFields.style.display = 'none';
                // Remove required attribute
                document.getElementById('birth_date').required = false;
                document.getElementById('nationality').required = false;
            }
        }
    </script>
</body>
</html>