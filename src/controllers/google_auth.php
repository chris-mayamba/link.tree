<?php
session_start();

// Simple gestion procédurale pour Google Sign-In
// Remplacez par votre CLIENT_ID Google
define('GOOGLE_CLIENT_ID', 'YOUR_GOOGLE_CLIENT_ID_HERE');

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['google_token'])) {
    $token = $_POST['google_token'];

    // Vérifier le token auprès de Google
    $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($token);
    $response = @file_get_contents($url);
    if ($response === false) {
        echo json_encode(['success' => false, 'message' => 'Impossible de vérifier le token']);
        exit;
    }

    $data = json_decode($response, true);

    // Vérifier que le token est destiné à notre client
    if ($data && isset($data['email']) && isset($data['aud']) && $data['aud'] === GOOGLE_CLIENT_ID) {
        // Authentification réussie (procédural)
        $_SESSION['user_email'] = $data['email'];
        $_SESSION['user_name'] = $data['name'] ?? explode('@', $data['email'])[0];

        echo json_encode([
            'success' => true,
            'redirect' => '../view/home.php'
        ]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Token invalide ou non destiné à cette application']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Mauvaise méthode']);

?>
