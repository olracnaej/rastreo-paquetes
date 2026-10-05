<?php

return [
    // Etapas en orden. El cliente ve el avance según la posición del estado actual.
    'stages' => [
        'Pedido en Amazon',
        'Recibido en Miami',
        'En tránsito a Costa Rica',
        'En aduana de Costa Rica',
        'Listo para entrega',
        'Entregado',
    ],

    'sheet_id'   => env('GOOGLE_SHEET_ID'),
    'sheet_name' => env('GOOGLE_SHEET_NAME', 'Historial'),
];
