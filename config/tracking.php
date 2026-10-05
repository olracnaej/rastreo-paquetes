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

    'sheets_url'    => env('SHEETS_WEBHOOK_URL'),
    'sheets_secret' => env('SHEETS_WEBHOOK_SECRET'),
];
