<?php
if (!function_exists('dbConnect')) {
    require_once __DIR__ . '/user.php';
}

/**
 * Récupère les liens d'une page
 */
function get_links_by_page_id($pageId)
{
    $db = dbConnect();
    $stmt = $db->prepare("SELECT * FROM links WHERE page_id = :page_id AND is_active = 1 ORDER BY position ASC, created_at DESC");
    $stmt->execute(['page_id' => $pageId]);
    return $stmt->fetchAll();
}

