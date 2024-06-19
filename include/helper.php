<?php

class Helper {
    /*
     * Checks database connection.
    */
    public static function getConnection() {
        $dsn = 'mysql:host=' . (defined('DB_HOST') ? DB_HOST : '') . ';dbname=' . (defined('DB_NAME') ? DB_NAME : '');

        try {
            $pdo = new PDO($dsn, (defined('DB_USER') ? DB_USER : 'default'), (defined('DB_PASS') ? DB_PASS : 'default'), []);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }

        return $pdo;
    }

    /*
     * Builds category tree recursively.
     */
    public static function buildCategoryTree(array $categories, $parentId = 0) {
        $branch = [];

        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $children = self::buildCategoryTree($categories, $category['categories_id']);
                if ($children) {
                    $branch[$category['categories_id']] = $children;
                } else {
                    $branch[$category['categories_id']] = $category['categories_id'];
                }
            }
        }

        return $branch;
    }
}
