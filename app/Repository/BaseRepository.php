<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository
{
    public Builder $query;

    public function __construct()
    {
        $this->query = app()->make($this->model())->newQuery();
    }

    abstract public function model();
}
