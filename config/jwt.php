<?php

return [
    'secret' => env('JWT_SECRET', '121342'), // Clé secrète pour signer les tokens
    'expiration' => 60, // Durée d'expiration en minutes
];
