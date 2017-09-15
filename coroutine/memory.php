<?php
$n = 100000;
$startTime = microtime(true);
$startMemory = memory_get_usage();
$array = range(1, $n);

foreach($array as $a) {
}

echo memory_get_usage() - $startMemory, " bytes\n";
echo microtime(true) - $startTime. " ms\n";


function xrange($start,$end,$step=1) {
    for($i=$start;$i<$end;$i+=$step) {
        yield $i;
    }
}
$startTime = microtime(true);
$startMemory = memory_get_usage();
$g = xrange(1,$n);

foreach($g as $i) {
}

echo memory_get_usage() - $startMemory, " bytes\n";
echo microtime(true) - $startTime. " ms\n";

?>

