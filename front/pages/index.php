<?php
require_once '../../back/Model/UserModel.php';
if (session_id() == "") session_start();
if (isset($_SESSION['user'])) var_dump($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="../components/registerLogin.js"></script>
</head>

<body>
    <?php require_once '../components/navBar.php'; ?>
    <?php if (!isset($_SESSION['user'])) : ?>
        <form method="POST" id="loginForm" class="authForm">
            <h2>Connexion</h2>
             <input type="text" name="loginEmail" placeholder="Email">
            <input type="password" name="loginPassword" placeholder="Mot de passe">
            <input type="submit" value="Connexion" class="authButton" id="loginButton" name="loginSubmit">
        </form>
        <form method="POST" id="registerForm" class="authForm">
            <h2>Inscription</h2>
            <input type="text" name="registerFirstName" placeholder="Prénom">
            <input type="text" name="registerLastName" placeholder="Nom">
            <input type="text" name="registerEmail" placeholder="Email">
            <input type="password" name="registerPassword" placeholder="Mot de passe">
            <input type="password" name="registerPasswordConfirm" placeholder="Confirmez votre mot de passe">
            <input type="submit" value="S'inscrire" class="authButton" id="registerButton" name="registerSubmit">
        </form>
    <?php endif; ?>
</body>

</html>