<?php

use App\lib\QueryBuilder;
use function DI\create;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\lib\Database\Database;
use App\lib\Database\DatabaseInterface;


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

    // Bind an interface to an implementation
    DatabaseInterface::class => create(Database::class),
];
