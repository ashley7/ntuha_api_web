<?php
return [
    'credentials' => env('FIREBASE_CREDENTIALS', storage_path('firebase/password.json')),
    'database'    => env('FIREBASE_DATABASE'),
];