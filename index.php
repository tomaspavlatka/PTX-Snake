<?php
header('content-type: text/plain; charset=utf-8');

require_once './bootstrap.php';
use \Ptx\Snake;

$snake_obj = new Snake();
$moves_2_test = [
    'FLERFF', 'EEEELLLL'
];

foreach($moves_2_test as $move) {
    try {
        $snake_obj->reset();
        $result = $snake_obj->move_snake($move);

        echo $move . ': ';
        echo ($result == -1) ? 'YES' : $result;
        echo "\r\n";
    } catch(\Ptx\SnakeException $e) {
        echo $e->getMessage();
    }
}