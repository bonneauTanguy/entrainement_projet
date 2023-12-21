<?php
session_start();

require_once('database/db.php');
require_once('security/connexion.php');

$conn = connectDB();

if (!isset($_SESSION['token']) || !isTokenValid($_SESSION['token'])) {
    header("Location: /index.php"); // Redirige vers la page de connexion
    exit();
}

$result = $conn->query("SELECT COUNT(*) AS total_clients FROM clients");
$row = $result->fetch_assoc();
$totalClients = $row['total_clients'];

$result = $conn->query("SELECT COUNT(*) AS total_vehicules FROM vehicules");
$row = $result->fetch_assoc();
$totalVehicules = $row['total_vehicules'];

$result = $conn->query("SELECT COUNT(*) AS total_rendezvous FROM rendezvous");
$row = $result->fetch_assoc();
$totalRendezvous = $row['total_rendezvous'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Garage Train</title>
</head>
<body>
    <h1>Tableau de Bord Garage Train</h1>
    <div>
        <h2>Clients</h2>
        <p>Total Clients: <?= $totalClients ?></p>
    </div>
    <div>
        <h2>Véhicules</h2>
        <p>Total Véhicules: <?= $totalVehicules ?></p>
    </div>
    <a href="vehicules.php" class="btn btn-primary">Gérer les Véhicules</a>
    <div>
        <h2>Rendez-vous</h2>
        <p>Total Rendez-vous: <?= $totalRendezvous ?></p>
    </div>

    <a href="security/connexion.php?logout=true" class="btn btn-danger">Déconnexion</a>

</body>
</html>
