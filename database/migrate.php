<?php

$basePath = __DIR__ . '/migrations';
require_once "$basePath/Migration.php";

$files = glob($basePath . '/*.php');

foreach ($files as $file) {
    if (basename($file) === 'Migration.php') continue;

    require_once $file;

    $class = pathinfo($file, PATHINFO_FILENAME);
    $class = preg_replace('/^\d{4}_\d{2}_\d{2}_/', '', $class);
    $class = str_replace(' ', '', ucwords(str_replace('_', ' ', $class)));

    if (!class_exists($class)) {
        echo "Classe $class não encontrada em $file\n";
        continue;
    }

    echo "Executando migration: $class\n";
    $instance = new $class();
    $instance->up();
}
