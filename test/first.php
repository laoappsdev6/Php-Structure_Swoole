<?php
require_once "./second.php";
class First
{
    public string $name;
    public function sss()
    {
        $this->name = "first";
        // echo $this->name;
        $namess = new Second();
        $namess->test();
    }
}
$kkk = new First();
$kkk->sss();
