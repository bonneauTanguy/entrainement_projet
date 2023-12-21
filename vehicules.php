<?php
session_start();

require_once('database/db.php');
require_once('security/connexion.php');

$conn = connectDB();

if (!isset($_SESSION['token']) || !isTokenValid($_SESSION['token'])) {
    header("Location: /index.php");
    exit();
}

$message = '';
$error = '';

// Gérer la suppression
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM vehicules WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "Véhicule supprimé avec succès.";
    } else {
        $error = "Erreur lors de la suppression du véhicule.";
    }

    $stmt->close();
}

// Récupérer la liste des véhicules
$result = $conn->query("SELECT * FROM vehicules");
$vehicules = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Véhicules</title>
</head>
<body>
<h1>Gestion des Véhicules</h1>
<?php if ($message): ?>
    <p><?= $message ?></p>
<?php endif; ?>
<?php if ($error): ?>
    <p><?= $error ?></p>
<?php endif; ?>
<a href="form/ajouter_vehicule.php" class="btn btn-success">Ajouter un Véhicule</a>
<table>
    <thead>
    <tr>
        <th>Marque</th>
        <th>Modèle</th>
        <th>Année</th>
        <th>Client</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($vehicules as $vehicule): ?>
        <tr>
            <td><?= htmlspecialchars($vehicule['marque']) ?></td>
            <td><?= htmlspecialchars($vehicule['modele']) ?></td>
            <td><?= htmlspecialchars($vehicule['annee']) ?></td>
            <td><?= htmlspecialchars($vehicule['client_id']) ?></td>
            <td>
                <form action="vehicules.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?');">
                    <input type="hidden" name="id" value="<?= $vehicule['id'] ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
