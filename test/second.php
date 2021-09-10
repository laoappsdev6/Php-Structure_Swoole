<?php
require_once "./first.php";
class Second extends First
{
    public string $ss = "svx";

    public function test()
    {
        echo $this->name . PHP_EOL;
    }
}
// $names = new Second();

// $names->test();
