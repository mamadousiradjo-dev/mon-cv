<?php
// backend/upload_profile.php
header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée.']);
    exit;
}

if (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Aucun fichier envoyé ou erreur d\'upload.']);
    exit;
}

$file = $_FILES['profile_photo'];

// 1. Vérification de la taille (max 5Mo)
$maxSize = 5 * 1024 * 1024; // 5 MB
if ($file['size'] > $maxSize) {
    echo json_encode(['success' => false, 'message' => 'Fichier trop volumineux (Max 5 MB).']);
    exit;
}

// 2. Vérification de l'extension
$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedTypes)) {
    echo json_encode(['success' => false, 'message' => 'Format non supporté. Autorisés: JPG, JPEG, PNG, GIF.']);
    exit;
}

// 3. Dossier de destination sécurisé avec __DIR__
$targetDir = __DIR__ . '/../images/upload/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Génération d'un nom unique pour éviter les conflits
$newFileName = 'profile_' . time() . '.' . $fileExtension;
$targetFilePath = $targetDir . $newFileName;
$dbFilePath = 'images/upload/' . $newFileName;

// 4. Upload et mise à jour en BDD
if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
    try {
        $stmt = $pdo->prepare("UPDATE user_profile SET profile_photo_path = :path WHERE id = 1");
        $stmt->execute([':path' => $dbFilePath]);

        echo json_encode([
            'success' => true,
            'message' => 'Photo de profil mise à jour avec succès !',
            'photo_url' => $dbFilePath
        ]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur BDD : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Échec du transfert du fichier.']);
}