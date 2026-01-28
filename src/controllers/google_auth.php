<?php
// Google auth endpoint neutralisé temporairement.
// Si vous voulez réactiver plus tard, remettez la validation du token ici.

header('Content-Type: application/json; charset=utf-8');
http_response_code(503);
echo json_encode(['success' => false, 'message' => 'Google auth temporairement désactivé']);
exit;

?>
