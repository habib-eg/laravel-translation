<?php

return [
    // ----------------------------------------
    //              Routes prefix             |
    // ----------------------------------------
    'prefix' => 'translation-manager',
    'namespace' => '\Habib\TranslationManager\Controllers',

    // ----------------------------------------
    //          Routes middleware             |
    // ----------------------------------------
    'middleware' => ['web', 'auth'],
];
