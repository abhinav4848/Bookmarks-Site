<?php
try {
    $db = new PDO('sqlite:bookmarks.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Drop old tables if they exist
    $db->exec("DROP TABLE IF EXISTS bookmarks");
    $db->exec("DROP TABLE IF EXISTS categories");

    // Create categories table
    $db->exec("
        CREATE TABLE categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL UNIQUE
        );
    ");

    // Create bookmarks table
    $db->exec("
        CREATE TABLE bookmarks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            url TEXT NOT NULL,
            notes TEXT,
            category_id INTEGER NOT NULL,
            FOREIGN KEY (category_id) REFERENCES categories(id)
        );
    ");

    // Read bookmarks from JSON file
    $json = file_get_contents('bookmarks.json');
    $data = json_decode($json, true);

    if (!$data || !isset($data['bookmarks'])) {
        die("Invalid JSON data.");
    }

    $insertCategory = $db->prepare("INSERT OR IGNORE INTO categories (name) VALUES (:name)");
    $getCategoryId = $db->prepare("SELECT id FROM categories WHERE name = :name");
    $insertBookmark = $db->prepare("INSERT INTO bookmarks (title, url, notes, category_id) VALUES (:title, :url, :notes, :category_id)");

    foreach ($data['bookmarks'] as $bookmark) {
        $categoryName = $bookmark['category'];

        // Insert category if not exists
        $insertCategory->execute([':name' => $categoryName]);

        // Get category id
        $getCategoryId->execute([':name' => $categoryName]);
        $categoryId = $getCategoryId->fetchColumn();

        // Insert bookmark
        $insertBookmark->execute([
            ':title' => $bookmark['title'],
            ':url' => $bookmark['url'],
            ':notes' => $bookmark['notes'],
            ':category_id' => $categoryId
        ]);
    }

    echo "Database setup and initial data inserted successfully.";
} catch (PDOException $e) {
    echo "Error setting up database: " . $e->getMessage();
}
