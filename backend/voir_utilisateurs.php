<?php
declare(strict_types=1);

// Ne pas exposer les données des utilisateurs sur une URL publique.
http_response_code(404);
