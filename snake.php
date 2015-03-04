<?php
require_once './bootstrap.php';
use \Ptx\Snake;

$snake_obj = new Snake();

echo 'Welcome to snake 1.0' . "\r\n";
echo '--------------------' . "\r\n";
echo 'F - Forward' . "\r\n";
echo 'L - Left' . "\r\n";
echo 'R - Right' . "\r\n";
echo 'E - Forward & Eat' . "\r\n\r\n";

$move = array_key_exists(1, $argv) ? $argv[1] : null;
if(empty($move)) {
    echo 'You have to specify the path for your snake, eg. php snake.php EEFFEE';
    exit;
}

try {
    $snake_obj->reset();
    $result = $snake_obj->move_snake($move);

    echo $move . ': ';
    echo ($result == -1) ? 'Survived' : sprintf('Snake aet himself in %d. step', $result);
    echo "\r\n";
} catch(\Ptx\SnakeException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
