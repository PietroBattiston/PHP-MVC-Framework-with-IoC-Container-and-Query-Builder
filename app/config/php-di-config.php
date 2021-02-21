<?php

use App\lib\QueryBuilder;
use function DI\create;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\lib\DB;

// return [
//   'DB' => create(DB::class),
//   'QueryBuilder' => create(QueryBuilder::class)
// ];
return [
    // Configure Twig
    Environment::class => function () {
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        
        return new Environment($loader);
    },
];
