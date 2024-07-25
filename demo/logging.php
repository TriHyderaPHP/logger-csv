<?php
require __DIR__.'/../vendor/autoload.php';

$log = new Trihydera\Log\Logger('demo', __DIR__. '/log', false);

$log->log('debug', 'all is good');
$log->log('error', 'opps');
?>