<?php

$directory = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources';

function getFiles(string $directory): array
{
    $files = [];

    foreach (glob($directory . DIRECTORY_SEPARATOR . '*') as $file) {
        if (is_dir($file)) {
            $files = array_merge($files, getFiles($file));

            continue;
        }

        if ($directory . DIRECTORY_SEPARATOR . 'hashes.json' === $file) {
            continue;
        }

        $files[] = $file;
    }

    return $files;
}

$files = getFiles($directory);
$content = [];

foreach ($files as $file) {
    $fileName = str_replace($directory . DIRECTORY_SEPARATOR, '', $file);
    $fileName = str_replace(DIRECTORY_SEPARATOR, '/', $fileName);
    $content[$fileName] = md5(file_get_contents($file));
}

file_put_contents($directory . DIRECTORY_SEPARATOR . 'hashes.json', json_encode($content));
