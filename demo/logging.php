<?php
require __DIR__.'/../vendor/autoload.php';

$log = new Trihydera\Log\Logger('demo', __DIR__. '/log', false);

$log->info('all is good');
$log->error('opps');

$log->info('all is {text}', [
    'text' => 'great'
]);
?>