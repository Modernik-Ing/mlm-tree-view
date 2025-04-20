<?php

use Modernik\MlmTreeView\LinkGenerator;
use Modernik\MlmTreeView\Placement\CenteredTreeLayoutEngine;
use Modernik\MlmTreeView\Renderer\LinkedHtmlTreeRenderer;
use Modernik\MlmTreeView\TreeNode;

require_once dirname(__DIR__) . '/vendor/autoload.php';

include("fake-data.php");
global $root;
global $binary;
global $ternary;

class BasicLinkGenerator implements LinkGenerator
{
    public function generate(TreeNode $node): ?string
    {
        return "/linked.php?id={$node->getId()}";
    }
}


// Création du renderer
$layout = new CenteredTreeLayoutEngine();
$renderer = new LinkedHtmlTreeRenderer($layout, new BasicLinkGenerator(), true);

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

<?php echo isset($_GET["id"])? "<h1>id = {$_GET['id']}</h1>":""?>

<h1>Réseau binaire Avec des Liens</h1>
<?= $renderer->render($binary) ?>

<h1>Réseau ternaire avec des liens</h1>
<?= $renderer->render($ternary) ?>

</body>
</html>
