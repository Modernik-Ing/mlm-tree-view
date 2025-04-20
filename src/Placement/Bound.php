<?php

namespace Modernik\MlmTreeView\Placement;

/**
 * Représente un rectangle délimité dans un espace 2D.
 *
 * Cette classe encapsule la position (`x`, `y`) ainsi que les dimensions (`width`, `height`)
 * d’un élément graphique dans un système de coordonnées cartésien, généralement utilisé
 * pour le rendu HTML, SVG ou toute autre interface graphique.
 *
 * @author Esaie Muhasa
 */
class Bound
{
    public function __construct(
        public int $x,
        public int $y,
        public int $width,
        public int $height
    ) {
    }

    /**
     * Retourne la position et la taille sous forme de style CSS inline.
     *
     * @return string Exemple : "left:100px;top:50px;width:120px;height:60px;"
     */
    public function toCss(): string
    {
        return "left:{$this->x}px;top:{$this->y}px;width:{$this->width}px;height:{$this->height}px;";
    }

    /**
     * Retourne les données du bound sous forme de tableau associatif.
     *
     * @return array{ x: int, y: int, width: int, height: int }
     */
    public function toArray(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
            'width' => $this->width,
            'height' => $this->height,
        ];
    }

    /**
     * Crée un objet Bound à partir d’un tableau associatif.
     *
     * @param array{ x: int, y: int, width: int, height: int } $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self($data['x'], $data['y'], $data['width'], $data['height']);
    }
}
