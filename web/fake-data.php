<?php

// Construction manuelle de l’arbre
use Modernik\MlmTreeView\GenericTreeNode;

$root = new GenericTreeNode(1, 'CEO', [
    new GenericTreeNode(2, 'A', [
        new GenericTreeNode(3, 'A1'),
        new GenericTreeNode(4, 'A2'),
        new GenericTreeNode(5, 'A3'),
        new GenericTreeNode(12, 'A4'),
    ]),
    new GenericTreeNode(6, 'B', [
        new GenericTreeNode(7, 'B1'),
        new GenericTreeNode(8, 'B2'),
    ]),
    new GenericTreeNode(9, 'C', [
        new GenericTreeNode(13, 'C1', [
            new GenericTreeNode(14, 'C11', [
                new GenericTreeNode(15, 'C111', [
                    new GenericTreeNode(16, 'C1111', [
                        new GenericTreeNode(17, '1'),
                        new GenericTreeNode(18, '2'),
                        new GenericTreeNode(19, '3'),
                        new GenericTreeNode(20, '4'),
                    ])
                ]),
            ]),
            new GenericTreeNode(21, 'C12', [
                new GenericTreeNode(22, 'X1'),
                new GenericTreeNode(23, 'X2'),
            ]),
            new GenericTreeNode(24, 'C13', [])
        ])
    ])
]);

$binary = new GenericTreeNode(1, 'ROOT', [
    new GenericTreeNode(2, 'A', [
        new GenericTreeNode(3, 'A1', [
            new GenericTreeNode("A11", 'A11'),
            new GenericTreeNode("A12", 'A12')
        ]),
        new GenericTreeNode(4, 'A2', [
            new GenericTreeNode(8, 'A21', [
                new GenericTreeNode("A211", 'A211'),
                new GenericTreeNode("A212", 'A212')
            ]),
            new GenericTreeNode(9, 'A22', [
                new GenericTreeNode(10, 'A221'),
                new GenericTreeNode(11, 'A222'),
            ]),
        ]),
    ]),
    new GenericTreeNode(5, 'B', [
        new GenericTreeNode(6, 'B1', [
            new GenericTreeNode(12, 'B11', [
                new GenericTreeNode(13, 'B111')
            ]),
            new GenericTreeNode("B12", 'B12')
        ]),
        new GenericTreeNode(7, 'B2', [
            new GenericTreeNode(14, 'B21'),
            new GenericTreeNode(14, 'B22')
        ]),
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
