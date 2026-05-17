<?php

return [
    'working_hours' => [
        'start' => env('SPA_OPENING_TIME', '08:00'),
        'end' => env('SPA_CLOSING_TIME', '22:00'),
        'slot_interval' => env('SPA_SLOT_INTERVAL', 30),
    ],
];
