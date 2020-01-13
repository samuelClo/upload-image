<?php
require_once '../vendor/autoload.php';

print_r($_FILES);
$loader = new \Twig\Loader\FilesystemLoader('./../templates');

$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

echo  $twig->render('index.html.twig', [
    'pitouf' => 'aaa',
]);

require '../src/Controllers/uploadFile.php';