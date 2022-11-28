<?php 
$allRules = \array_merge(
    require __DIR__ . '/endpoints/source.php',
    require __DIR__ . '/endpoints/user.php',
    require __DIR__ . '/endpoints/flight.php',
);

return [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => $allRules,
];
