<?php

namespace src\application;

class AppPHPAndDataBase
{
    public function run(): void
    {
        $solution = new Solution();

        $solution->fetchAll();

        $solution->prepare();

        $solution->view();
    }
}
