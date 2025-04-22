<?php

use Modernik\MlmTreeView\Placement\CenteredTreeLayoutEngine;
use Modernik\MlmTreeView\Placement\TreeLayoutEngine;
use Modernik\MlmTreeView\Renderer\BasicHtmlTreeRenderer;

require_once dirname(__DIR__) . '/vendor/autoload.php';
include("fake-data.php");

global $root;
global $binary;
global $ternary;
global $notEquilibrateBinary;


// Création du renderer
$layoutHorizontal = new CenteredTreeLayoutEngine(70, 60, 50, 80, TreeLayoutEngine::ORIENTATION_HORIZONTAL);
$layoutVertical = new CenteredTreeLayoutEngine(70, 60, 90, 40, TreeLayoutEngine::ORIENTATION_VERTICAL);

$rendererHorizontal = new BasicHtmlTreeRenderer($layoutHorizontal);
$rendererVertical = new BasicHtmlTreeRenderer($layoutVertical);
$notEquilibrateBinaryRender = new BasicHtmlTreeRenderer(new CenteredTreeLayoutEngine(200, 100, 50, 50));

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

<h1>Réseau binaire vertical</h1>
<?= $rendererVertical->render($binary) ?>

<h1>Réseau binaire horizontal</h1>
<?= $rendererHorizontal->render($binary) ?>

<h1>Réseau binaire en déséquilibre</h1>
<?= $notEquilibrateBinaryRender->render($notEquilibrateBinary) ?>

<h1>Réseau ternaire</h1>
<?= $rendererVertical->render($ternary) ?>

</body>
</html>
