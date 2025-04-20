<?php

use Modernik\MlmTreeView\GenericTreeNode;
use Modernik\MlmTreeView\Placement\CenteredTreeLayoutEngine;
use Modernik\MlmTreeView\Renderer\HtmlTreeRenderer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Construction manuelle de l’arbre
$root = new GenericTreeNode(1, 'CEO', [
    new GenericTreeNode(2, 'Manager A', [
        new GenericTreeNode(3, 'Agent A1'),
        new GenericTreeNode(4, 'Agent A2'),
        new GenericTreeNode(5, 'Agent A3'),
    ]),
    new GenericTreeNode(6, 'Manager B', [
            new GenericTreeNode(7, 'Agent B1'),
            new GenericTreeNode(8, 'Agent B2'),
    ]),
    new GenericTreeNode(9, 'Manager C'),
    new GenericTreeNode(10, 'Manager D'),
    new GenericTreeNode(11, 'Manager E')
]);

$binary = new GenericTreeNode(1, 'ROOT', [
    new GenericTreeNode(2, 'A', [
        new GenericTreeNode(3, 'A1'),
        new GenericTreeNode(4, 'A2', [
                new GenericTreeNode(8, 'A21'),
                new GenericTreeNode(9, 'A22', [
                        new GenericTreeNode(10, 'A221'),
                        new GenericTreeNode(11, 'A222'),
                ]),
        ]),
    ]),
    new GenericTreeNode(5, 'B', [
        new GenericTreeNode(6, 'B1', [
                new GenericTreeNode(12, 'B11', [
                        new GenericTreeNode(13, 'B111', [
                                new GenericTreeNode(14, 'B1111'),
                                new GenericTreeNode(14, 'B1112')
                        ])
                ]),
        ]),
        new GenericTreeNode(7, 'B2'),
    ])
]);

$ternary = new GenericTreeNode(1, 'ROOT', [
    new GenericTreeNode(2, 'A', [
        new GenericTreeNode(3, 'A1'),
        new GenericTreeNode(4, 'A2'),
        new GenericTreeNode(5, 'A3'),
    ]),
    new GenericTreeNode(6, 'B', [
        new GenericTreeNode(7, 'B1'),
        new GenericTreeNode(8, 'B2'),
        new GenericTreeNode(9, 'B3'),
    ]),
    new GenericTreeNode(10, 'C', [
        new GenericTreeNode(11, 'C1'),
        new GenericTreeNode(12, 'C2'),
        new GenericTreeNode(13, 'C3'),
    ])
]);


// Création du renderer
$layout = new CenteredTreeLayoutEngine();
$renderer = new HtmlTreeRenderer($layout, true);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MLM Tree View</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: sans-serif;
            background-color: #f0f2f5;
        }
    </style>
</head>
<body>

<h1>Démo de l’Arbre MLM</h1>
<?= $renderer->render($root) ?>

<h1>Réseau binaire</h1>
<?= $renderer->render($binary) ?>

<h1>Réseau ternaire</h1>
<?= $renderer->render($ternary) ?>

</body>
</html>
