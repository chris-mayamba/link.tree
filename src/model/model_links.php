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

/**
 * Supprime tous les liens d'une page (pour remplacement complet)
 */
function delete_links_by_page_id($pageId, $db = null) {
    if ($db === null) $db = dbConnect();
    $stmt = $db->prepare("DELETE FROM links WHERE page_id = :page_id");
    return $stmt->execute(['page_id' => $pageId]);
}

/**
 * Crée un lien
 */
function create_link($pageId, $title, $url, $icon, $position, $db = null) {
    if ($db === null) $db = dbConnect();
    $stmt = $db->prepare("INSERT INTO links (page_id, title, url, icon, position) VALUES (:page_id, :title, :url, :icon, :position)");
    return $stmt->execute([
        'page_id' => $pageId,
        'title' => $title,
        'url' => $url,
        'icon' => $icon,
        'position' => $position
    ]);
}

