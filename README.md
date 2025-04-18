# MLM Tree View

📈 **MLM Tree View** est une bibliothèque PHP légère et extensible permettant de générer des **arbres hiérarchiques** de type **marketing de réseau (MLM)** avec un rendu **HTML stylisé prêt à l'emploi**.

---

## 🚀 Fonctionnalités

- ✅ Génération automatique d'arborescences MLM à partir de structures de données PHP
- 🎨 Rendu HTML propre et facilement intégrable dans une page web
- 💅 Style CSS inclus
- ⚙️ Aucune dépendance externe (autonome)
- 🧩 Prise en charge des structures récursives (niveaux illimités)

---

## 📦 Installation

Utilisez Composer pour installer le package :

```bash
composer require modernik/mlm-tree-view
```

---

## 🛠 Utilisation de base

### Exemple minimal

```php

use Esaiemuhasa\MlmTreeView\Model\DefaultTreeNode;
use Esaiemuhasa\MlmTreeView\HTMLTreeRenderer;

$tree = new DefaultTreeNode('Leader', [
    new DefaultTreeNode('Membre A'),
    new DefaultTreeNode('Membre B', [
        new DefaultTreeNode('Membre B1'),
        new DefaultTreeNode('Membre B2'),
    ]),
]);

$renderer = new HTMLTreeRenderer();
echo $renderer->render($tree);
```

### Avec style embarqué

```php
echo $renderer->render($tree, withStyles: true);
```

> 💡 Le paramètre `withStyles: true` injecte le CSS directement dans la page. Pratique pour un rendu rapide sans configuration.

---

## 🎨 Personnalisation du style

Le style est écrit en **CSS** (fichier `mlm-tree.css`).

Vous pouvez :
- Inclure manuellement le CSS dans votre layout
- Modifier le CSS pour adapter l’apparence de l’arbre à votre charte graphique

```html
<link rel="stylesheet" href="/chemin/vers/mlm-tree.css">
```

---

## 🧱 Structure des données attendue

> (À ajouter bientôt) 

---

## 🧪 Tests

> (À ajouter bientôt)

---

## 📄 Licence

Ce projet est sous licence **MIT** — vous pouvez l’utiliser librement dans vos projets personnels ou commerciaux.

---

Pour toute suggestion, amélioration ou bug, n’hésitez pas à créer une *issue* ou un *pull request*.

---
