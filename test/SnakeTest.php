<?php
require_once './bootstrap.php';
use \Ptx\Snake;

class SnakeTest extends PHPUnit_Framework_TestCase
{

    /**
     * Tests whether we do have class name Snake
     */
    public function testSnakeClass_exits()
    {
        $this->assertTrue(class_exists('\Ptx\Snake'));
    }

    /**
     * Checks that init length param is working
     */
    public function testSnakeClass_InitLength_CorrectSnake()
    {
        $snake_obj = new Snake([
            'init_length' => 3,
        ]);

        $expected = [ [0,0], [1,0], [2,0], [3,0] ];
        $this->assertEquals($expected, $snake_obj->get_positions());
    }

    public function testReset_MoveSnakeAndReset_CorrectPosition()
    {
        $snake_obj = new Snake();
        $snake_obj->move_snake('FFEEFFEE');
        $snake_obj->reset();

        $this->assertEquals([[0,0], [1,0]], $snake_obj->get_positions());
        $this->assertEquals(0, $snake_obj->get_steps());
    }

    public function testMoveSnake_UnknownMove_ThrowsException()
    {
        $snake_obj = new Snake();
        $exception = false;
        try {
            $snake_obj->move_snake('FFEEFFEED');
        } catch(\Ptx\SnakeException $e) {
            $exception = true;
        }

        $this->assertTrue($exception);
    }


    /**
     * @param $move - snake path
     * @param $expected - what is an expected result.
     * @dataProvider data_4_move_tests
     * @throws \Ptx\SnakeException
     */
    public function testSnakeMove_Path_CorrectResults($move, $expected)
    {
        $snake_obj = new Snake();
        $snake_obj->move_snake($move);

        $this->assertEquals($expected, $snake_obj->get_positions(), $move);
    }

    /**
     * @param $move - snake path
     * @param $expected - what is an expected result.
     * @dataProvider data_4_survive_tests
     * @throws \Ptx\SnakeException
     */
    public function testSnakeMove_Path_Survive($move, $expected)
    {
        $snake_obj = new Snake();
        $this->assertEquals($expected, $snake_obj->move_snake($move), $move);
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function data_4_move_tests()
    {
        return [
            ['FFF', [[3,0], [4,0]]],
            ['FFL', [[3,0], [3,1]]],
            ['FLL', [[2,1], [1,1]]],
            ['FRR', [[2,-1], [1, -1]]],
            ['FFLLRRFF', [[4,2], [5,2]]],
            ['FE', [[1,0], [2,0], [3,0]]],
            ['FEE', [[1,0], [2,0], [3,0], [4,0]]],
            ['FEEL', [[2,0], [3,0], [4,0], [4,1]]],
            ['FLERFF', [[3,2], [4,2], [5,2]]],
        ];
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function data_4_survive_tests()
    {
        return [
            ['FFF', -1],
            ['FFL', -1],
            ['FLL', -1],
            ['FRR', -1],
            ['FFLLRRFF', -1],
            ['FE', -1],
            ['FEE', -1],
            ['FEEL', -1],
            ['FLERFF', -1],
            ['EEEELLLL', 7],
        ];
    }
}