<?php
$start_time = microtime(true);

require_once './include/config.php';
require_once './include/helper.php';
require_once './vendor/autoload.php';

use Symfony\Component\VarDumper\VarDumper;

Kint\Renderer\RichRenderer::$theme = KINT_THEME . '.css';
$pdo = Helper::getConnection();

// Fetch categories from the database without caching results
$query = $pdo->query('SELECT SQL_NO_CACHE `categories_id`, `parent_id`, NOW() FROM `categories`');
$categories = $query->fetchAll(PDO::FETCH_ASSOC);
$categoryTree = Helper::buildCategoryTree($categories);

// Kint
d($categoryTree);

// Symfony VarDumper
VarDumper::dump($categoryTree);

$finish_time = microtime(true);
echo '<p>Started at: ' . $start_time . ' (' . date('Y-m-d H:i:s', $start_time) . ')</p>';
echo '<p>Finished at: ' . $finish_time . '(' . date('Y-m-d H:i:s', $finish_time) . ')</p>';
echo '<p>Execution time: ' . ($finish_time - $start_time) . ' seconds</p>';
