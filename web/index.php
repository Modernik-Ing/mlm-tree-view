<?php

use Modernik\MlmTreeView\GenericTreeNode;
use Modernik\MlmTreeView\Placement\CenteredTreeLayoutEngine;
use Modernik\MlmTreeView\Renderer\HtmlTreeRenderer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Construction manuelle de l’arbre
$root = new GenericTreeNode(1, 'CEO', null, [
    new GenericTreeNode(2, 'Manager A', null, [
        new GenericTreeNode(5, 'Agent A1'),
        new GenericTreeNode(5, 'Agent A2'),
        new GenericTreeNode(5, 'Agent A3'),
    ]),
    new GenericTreeNode(3, 'Manager B', null, [
            new GenericTreeNode(5, 'Agent B1'),
            new GenericTreeNode(5, 'Agent B2'),
    ]),
    new GenericTreeNode(4, 'Manager C'),
    new GenericTreeNode(4, 'Manager D'),
    new GenericTreeNode(4, 'Manager E'),
    new GenericTreeNode(4, 'Manager F'),
]);


// Création du renderer
$layout = new CenteredTreeLayoutEngine();
$renderer = new HtmlTreeRenderer($layout, true);

// Rendu HTML
$html = $renderer->render($root);

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

<?= $html ?>

</body>
</html>
