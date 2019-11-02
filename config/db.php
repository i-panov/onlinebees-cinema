<?php

$dbname = 'onlinebees_cinema';

if (YII_ENV_TEST)
    $dbname .= '_tests';

return [
    'class' => 'yii\db\Connection',
    'charset' => 'utf8',
    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
    'dsn' => "mysql:host=localhost;dbname=$dbname",
    'username' => 'root',
    'password' => '',
];
