<?php
/*
function xrange($start, $limit, $step = 1) {
    for ($i = $start; $i <= $limit; $i += $step) {
        yield $i + 1 => $i; // �ؼ��� yield ��������һ�� generator
    }
}

// ���ǿ�����������
foreach (xrange(0, 10, 2) as $key => $value) {
    printf("%d %d\n", $key, $value);
}
*/


function xrange($start, $end, $step = 1) {
  for ($i = $start; $i <= $end; $i += $step) {
    yield $i;
  }
}

/*foreach (xrange(1, 1000000) as $num) {
  echo $num, "\n";
}
*/
$range = xrange(1, 10);
var_dump($range);
var_dump($range instanceof Iterator);

?>
