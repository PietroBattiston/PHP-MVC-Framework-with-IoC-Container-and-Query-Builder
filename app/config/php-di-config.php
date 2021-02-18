<?php

use App\lib\QueryBuilder;
use function DI\create;
//require_once __DIR__.'/User.php';
use App\lib\DB;

return [
  'DB' => create(DB::class),
  'QueryBuilder' => create(QueryBuilder::class)
];