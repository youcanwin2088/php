<?php
function logger($fileName) {
    $fileHandle = fopen($fileName,'a');
    while(true) {
        fwrite($fileHandle,yield . "\n");
    }
}
$logger = logger(__DIR__.'/log');
var_dump($logger->send('Foo'));
var_dump($logger->send('Bar'));
?>
