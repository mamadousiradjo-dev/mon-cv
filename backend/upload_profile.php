<?php
declare(strict_types=1);

// À réactiver après l'authentification et l'autorisation du propriétaire.
http_response_code(403);
header('Content-Type: application/json; charset=utf-8');
echo json_encode([
    'success' => false,
    'message' => 'Modification de la photo désactivée : authentification requise.',
], JSON_UNESCAPED_UNICODE);
