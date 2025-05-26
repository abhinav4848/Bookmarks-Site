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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thoughtful Websites – Bookmark Sheet</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
    <h1 id="mainTitle">🧠 Thoughtful Websites Bookmark Sheet</h1>
    <input type="text" id="searchInput" placeholder="Search websites or notes...">
 
    <?php foreach ($grouped as $category => $items): ?>
        <div class="category">
            <h2><?= htmlspecialchars($category) ?></h2>
            <table>
                <thead>
                    <tr>
                        <th>Website</th>
                        <th>Your Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td>
                            <a href="<?= htmlspecialchars($item['url']) ?>" target="_blank"><?= htmlspecialchars($item['title']) ?></a>
                        </td>
                        <td class="notes">
                            <?= htmlspecialchars($item['notes']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
    </main>

    <footer class="site-footer">
        <div id="footer" class="hidden">Visible bookmarks: <span id="footerCount">0</span></div>
        <div class="footer-content">
            <a href="export.php" target="_blank" rel="noopener noreferrer" class="bookmark-link">Export Bookmarks</a>
        </div>
    </footer>

    
<script src="script.js"></script>
</body>

</html>