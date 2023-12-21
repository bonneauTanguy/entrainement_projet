<?php
session_start();

require_once('../database/db.php');
require_once('../security/connexion.php');

$conn = connectDB();

if (!isset($_SESSION['token']) || !isTokenValid($_SESSION['token'])) {
    header("Location: /index.php");
    exit();
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $annee = $_POST['annee'];
    $client_id = $_POST['client_id'] ?: NULL;

    // Préparation de la requête SQL
    $stmt = $conn->prepare("INSERT INTO vehicules (marque, modele, annee, client_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $marque, $modele, $annee, $client_id);

    // Exécution de la requête
    if ($stmt->execute()) {
        $_SESSION['message'] = "Véhicule ajouté avec succès.";
        header("Location: ../vehicules.php"); // Assurez-vous que le chemin est correct
        exit();
    } else {
        // Si l'insertion échoue, stockez le message d'erreur dans la session pour l'affichage
        $_SESSION['error'] = "Erreur lors de l'ajout du véhicule : " . $stmt->error;
    }

    $stmt->close();
}

// Redirigez ici si le formulaire n'est pas soumis ou si l'insertion échoue
if (isset($_SESSION['error'])) {
    header("Location: ../vehicules.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Véhicule</title>
</head>
<body>
<h1>Ajouter un Nouveau Véhicule</h1>
<form action="" method="post">
    <div>
        <label for="marque">Marque:</label>
        <input type="text" id="marque" name="marque" required>
    </div>
    <div>
        <label for="modele">Modèle:</label>
        <input type="text" id="modele" name="modele" required>
    </div>
    <div>
        <label for="annee">Année:</label>
        <input type="number" id="annee" name="annee">
    </div>
    <div>
        <label for="client_id">ID Client (facultatif):</label>
        <input type="number" id="client_id" name="client_id">
    </div>
    <button type="submit">Ajouter</button>
</form>
</body>
</html>