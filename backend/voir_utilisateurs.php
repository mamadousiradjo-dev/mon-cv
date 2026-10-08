<?php
require_once 'db.php';

try {
    // Récupère uniquement l'id, le nom et l'email
    $stmt = $pdo->query("SELECT id, nom, email FROM utilisateurs");
    $utilisateurs = $stmt->fetchAll();

    echo "<h2>Liste des utilisateurs inscrits :</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Email</th></tr>";

    foreach ($utilisateurs as $user) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($user['id']) . "</td>";
        echo "<td>" . htmlspecialchars($user['nom']) . "</td>";
        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>