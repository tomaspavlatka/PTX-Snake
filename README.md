#PTX-Snake

Small and simple class to play with old game called Snake. You can initiate a snake and instruct him, where to go. The system will check the path and will let you know whether snake survived or he aet himself on the way. 

If everything goes well, system will return -1. If snake aet himself, system will return a number of a step when this happened. 

##Example
```
<?php
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
```