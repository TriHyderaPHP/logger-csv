<?php
require __DIR__.'/../vendor/autoload.php';

$log = new Trihydera\Log\Log('demo', __DIR__. '/log', false);
$log->out('test', 'message');
?>