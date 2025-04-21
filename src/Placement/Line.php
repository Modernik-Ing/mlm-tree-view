<?php

namespace Modernik\MlmTreeView\Placement;

/**
 * Représente une ligne droite entre deux points dans un espace 2D.
 *
 * Cette classe est utilisée pour stocker les coordonnées d'une ligne à dessiner,
 * par exemple dans un rendu SVG ou une structure d’arbre graphique.
 *
 * Les points sont définis par deux paires de coordonnées :
 * - (x1, y1) : point de départ
 * - (x2, y2) : point d’arrivée
 */
class Line
{
    /** @var float Coordonnée X du point de départ */
    public float $x1;

    /** @var float Coordonnée Y du point de départ */
    public float $y1;

    /** @var float Coordonnée X du point d’arrivée */
    public float $x2;

    /** @var float Coordonnée Y du point d’arrivée */
    public float $y2;

    /**
     * Initialise une nouvelle ligne avec des coordonnées personnalisées.
     *
     * @param float $x1 Coordonnée X du point de départ (par défaut 0)
     * @param float $y1 Coordonnée Y du point de départ (par défaut 0)
     * @param float $x2 Coordonnée X du point d’arrivée (par défaut 0)
     * @param float $y2 Coordonnée Y du point d’arrivée (par défaut 0)
     */
    public function __construct(float $x1 = 0, float $y1 = 0, float $x2 = 0, float $y2 = 0)
    {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
    }
}

