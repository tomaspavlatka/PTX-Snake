<?php namespace Ptx;

/**
 * Class Snake
 */
class Snake
{

    /**
     * holds info about snake's direction
     * F - forward, D - down, U - up, B - back
     * @var string
     */
    protected $_direction = 'F';

    /**
     * Holds information about how long a snake is at the beginning
     * @var int
     */
    protected $_init_length = 1;

    /**
     * keeps position for actual snake
     * @var array
     */
    protected $_positions = [];

    /**
     * counter how many steps a snake has done so far
     * @var int
     */
    protected $_steps = 0;

    /**
     * Class constructor
     *
     * @param array $params - additional params for the snake,
     * e.g. init_length set how long a snake is at the beginning.
     */
    public function __construct(array $params = array())
    {
        if(isset($params['init_length'])) {
            $this->_init_length = (int)$params['init_length'];
        }

        // Init snake.
        $this->_init_snake();
    }

    /**
     * Reset snake
     * brings snake to the default position.
     */
    public function reset()
    {
        $this->_init_snake();
        $this->_steps = 0;
    }

    /**
     * Moves snake forward
     *
     * @param bool $eat - did snake eat?
     * @return bool
     */
    public function move_forward($eat = false)
    {
        $snake_head = $this->_get_snake_head();

        if($this->_direction == 'F') {
            $next_step = [
                ++$snake_head[0], $snake_head[1]
            ];
        } else if($this->_direction == 'D') {
            $next_step = [
                $snake_head[0], --$snake_head[1]
            ];
        } else if($this->_direction == 'U') {
            $next_step = [
                $snake_head[0], ++$snake_head[1]
            ];
        } else if($this->_direction == 'B') {
            $next_step = [
                --$snake_head[0], $snake_head[1]
            ];
        }

        return $this->_move_snake_to($next_step, 'F', !$eat);
    }

    /**
     * Moves snake to the left.
     *
     * @return bool
     */
    public function move_left()
    {
        $snake_head = $this->_get_snake_head();

        if($this->_direction == 'F') {
            $next_step = [
                $snake_head[0], ++$snake_head[1]
            ];
        } else if($this->_direction == 'D') {
            $next_step = [
                ++$snake_head[0], $snake_head[1]
            ];
        } else if($this->_direction == 'U') {
            $next_step = [
                --$snake_head[0], $snake_head[1]
            ];
        } else if($this->_direction == 'B') {
            $next_step = [
                $snake_head[0], --$snake_head[1]
            ];
        }

        return $this->_move_snake_to($next_step, 'L');
    }

    /**
     * Moves snake to the fight
     *
     * @return bool
     */
    public function move_right()
    {
        $snake_head = $this->_get_snake_head();

        if($this->_direction == 'F') {
            $next_step = [
                $snake_head[0], --$snake_head[1]
            ];
        } else if($this->_direction == 'D') {
            $next_step = [
                --$snake_head[0], $snake_head[1]
            ];
        } else if($this->_direction == 'U') {
            $next_step = [
                ++$snake_head[0], $snake_head[1]
            ];
        } else if($this->_direction == 'B') {
            $next_step = [
                $snake_head[0], ++$snake_head[1]
            ];
        }

        return $this->_move_snake_to($next_step, 'R');
    }

    /**
     * Moves snake according to specified path
     *
     * @param string $path - string of path
     * F - forward, L - left, R - right, E - eat
     * @return int -1: move successful, any other number: snake was not able
     * to move this way, return number of steps he has made so far
     * @throws \Ptx\SnakeException
     */
    public function move_snake($path)
    {
        $survived = true;
        for($i = 0; $i < strlen($path); $i++) {
            switch($path[$i]) {
                case 'E':
                    $survived *= $this->move_forward(true);
                    break;
                case 'F':
                    $survived *= $this->move_forward();
                    break;
                case 'L':
                    $survived *= $this->move_left();
                    break;
                case 'R':
                    $survived *= $this->move_right();
                    break;
                default:
                    throw new SnakeException('Unknown move ' . $path[$i], 101);
            }

            if(!$survived) {
                break;
            }
        }

        if($survived) {
            return -1;
        } else {
            return $this->get_steps();
        }
    }

    /**
     * @return array
     */
    public function get_positions()
    {
        return $this->_positions;
    }

    /**
     * @return int
     */
    public function get_steps()
    {
        return $this->_steps;
    }

    /**
     * Add positions for a snake
     *
     * @param array $position - position
     * @param bool $remove_last - remove last
     */
    protected function _add_position($position, $remove_last)
    {
        $this->_positions[] = $position;

        if ($remove_last) { // Remove last - basically snake didn't eat in this step.
            array_shift($this->_positions);
        }
    }

    /**
     * @return array actual position of snake head
     */
    protected function _get_snake_head()
    {
        return end($this->_positions);
    }

    /**
     * Initialize snake
     *
     * takes $this->_init_length and creates snake
     * which is as long as requested.
     */
    protected function _init_snake()
    {
        $this->_positions = [
            [0,0]
        ];

        for($i = 0; $i < $this->_init_length; $i++) {
            $this->_positions[] = [
                $i + 1, 0
            ];
        }
    }

    /**
     * Moves snake to another position
     *
     * @param array $position - new position
     * @param string $direction - direction
     * @param bool $remove_last - remove last position
     * @return bool
     */
    protected function _move_snake_to($position, $direction, $remove_last = true) {
        $this->_steps++; // Add another step

        $success = false;
        if($this->_validate_step($position)) {
            $success = true; // Mark step as successful

            $this->_update_direction($direction); // Update direction
            $this->_add_position($position, $remove_last); // Add position for snake
        }

        return $success;
    }

    /**
     * Update direction base on snake's move
     * @param $move - snake move
     */
    protected function _update_direction($move)
    {
        if($move == 'L') {
            switch($this->_direction) {
                case 'F':
                    $this->_direction = 'U';
                    break;
                case 'U':
                    $this->_direction = 'B';
                    break;
                case 'D':
                    $this->_direction = 'F';
                    break;
                case 'B':
                    $this->_direction = 'D';
                    break;
            }
        } else if($move == 'R') {
            switch($this->_direction) {
                case 'F':
                    $this->_direction = 'D';
                    break;
                case 'U':
                    $this->_direction = 'F';
                    break;
                case 'D':
                    $this->_direction = 'B';
                    break;
                case 'B':
                    $this->_direction = 'U';
                    break;
            }
        }
    }

    /**
     * @param $step
     * @return bool
     */
    protected function _validate_step($step)
    {
        $key = array_search($step, $this->_positions);
        return is_numeric($key) ? false : true;
    }
}