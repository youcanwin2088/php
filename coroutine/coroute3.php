<?php

function gen() {
    $ret = (yield 'yield1');
    var_dump("-----0 ".$ret);
    $ret = (yield 'yield2');
    var_dump("------0 ".$ret);
}

$g = gen();
var_dump("-------1".$g->current());
var_dump("-----2".$g->send('ret1'));
var_dump("---------3".$g->send('ret2'));


?>
