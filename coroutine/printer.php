<?php

function printer()
{
    while (true) {
        printf("receive: %s\n", yield);
    }
}

$printer = printer();

$printer->send('hello');
$printer->send('world');
?>
