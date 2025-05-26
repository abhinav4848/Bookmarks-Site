<?php
$db = new PDO('sqlite:bookmarks.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch bookmarks with their categories
$query = $db->query("
    SELECT bookmarks.title, bookmarks.url, bookmarks.notes, categories.name AS category
    FROM bookmarks
    JOIN categories ON bookmarks.category_id = categories.id
    ORDER BY categories.name, bookmarks.title
");

$bookmarks = $query->fetchAll(PDO::FETCH_ASSOC);

// Group bookmarks by category
$grouped = [];
foreach ($bookmarks as $bm) {
    $grouped[$bm['category']][] = $bm;
}

header('Content-Type: application/json');
echo json_encode(["bookmarks" => $grouped], JSON_PRETTY_PRINT);
?>