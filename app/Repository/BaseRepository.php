<?php

namespace App\Repository;

abstract class BaseRepository
{
    public function __construct()
    {
        $this->model = app()->make($this->model());
    }

    abstract public function model();
}
