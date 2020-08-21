<?php

return [
    'route' => [
        'namespace' => 'App\\Http\\Controllers\\admin'
    ],
    'directory' => [
        'controller' => app_path('Http/Controllers/admin'),
        'model' => app_path('Models/admin'),
    ],
    'database' => [
        'user_model' => \App\Models\admin\User::class,
    ]
];
