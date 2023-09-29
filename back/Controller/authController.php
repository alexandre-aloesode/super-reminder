<?php
require_once '../Model/UserModel.php';
if (session_id() == "") session_start();


if (isset($_POST["registerFirstName"]) && isset($_POST["registerLastName"]) && isset($_POST["registerEmail"]) && isset($_POST["registerPassword"]) && isset($_POST["registerPasswordConfirm"])) {
    try {
        $register = new \App\Model\UserModel();
        $register->register([
            ':first_name' => $_POST['registerFirstName'],
            ':last_name' => $_POST['registerLastName'],
            ':email' => $_POST['registerEmail'],
            ':password' => password_hash($_POST['registerPassword'], PASSWORD_DEFAULT),
        ]);
        $_SESSION['user'] = $register->setSession($_POST["registerEmail"]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Email déjà utilisé']);
    }
}

if (isset($_POST["loginEmail"]) && isset($_POST["loginPassword"])) {
    $login = new \App\Model\UserModel();
    $checkExistingMail = $login->readOneByString($_POST['loginEmail'], 'email');
    if (!empty($checkExistingMail) && password_verify($_POST['loginPassword'], $checkExistingMail[0]['password'])) {
        $_SESSION['user'] = $login->setSession($_POST["loginEmail"]);
        // header('Location: ../../front/pages/toDoList.php');
        echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
    }
}

if (isset($_POST['logOut'])) {
    session_destroy();
    unset($_SESSION['user']);
    header('Location: ../pages/index.php');
}
