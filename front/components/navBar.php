<?php
require_once '../../back/Model/UserModel.php';
if (session_id() == "") session_start();

if (isset($_POST['disconnect'])) {
    session_destroy();
    header('Location: ../pages/index.php');
}
?>

<nav>
    <div id="logoDiv">
        <img src="../assets/logo.jpg" alt="logo" id="logo">
        <span>TrelloDuBled</span>
    </div>
    <?php if (isset($_SESSION['user'])) : ?>
        <a href="../pages/toDoList.php" class="nav-link">Ma To Do List</a>
        <a href="../pages/account.php" class="nav-link">Mon Compte</a>
        <form method="POST" id="logOutForm">
            <button type="submit" name="disconnect" id="decoButton" class="authentication-btn">Déconnexion</button>
        </form>
    <?php endif ?>
</nav>