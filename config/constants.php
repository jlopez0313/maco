<?php

return [
    'origenes' => [
        [
            'key' => 'N',
            'valor' => 'Nacional',
        ],
        [
            'key' => 'I',
            'valor' => 'Importado',
        ],
    ],

    'facturas' => [
        'estados' => [
            [
                'key' => 'A',
                'valor' => 'Abierta',
            ],
    
            [
                'key' => 'C',
                'valor' => 'Cerrada',
            ],
        ],
        'resoluciones' => [
          'estados' => [
                [
                    'key' => 'A',
                    'valor' => 'Activo',
                ],
        
                [
                    'key' => 'I',
                    'valor' => 'Inactivo',
                ],  
            ],
        ],
    ],

    'impuestos' => [
        'tarifas' => [
            [
                'key' => 'V',
                'valor' => 'Valor',
            ],
            [
                'key' => 'P',
                'valor' => 'Porcentaje',
            ],
        ],
        'tipos' => [
            [
                'key' => 'I',
                'valor' => 'Impuesto',
            ],
            [
                'key' => 'R',
                'valor' => 'Retención',
            ],
        ],
    ],
    'S_N' => [
        [
            'key' => 'S',
            'valor' => 'SI',
        ],
        [
            'key' => 'N',
            'valor' => 'NO',
        ],
    ]
];
