<?php
require_once 'config.php';
require_once 'auth.php';

$auth = new Auth();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if ($auth->login($email, $password)) {
        // Redirect based on user role
        $role = Auth::getUserRole();
        header("Location: {$role}_dashboard.php");
        exit();
    } else {
        $error = "Email ou mot de passe incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="auth-container">
        <h1>Connexion</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte? <a href="register.php">S'inscrire</a></p>
    </div>
</body>
</html>