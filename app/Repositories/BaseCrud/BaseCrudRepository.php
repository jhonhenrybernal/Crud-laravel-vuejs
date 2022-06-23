<?php

namespace App\Repositories\BaseCrud;

use App\Models\BasesCrud;
use App\Repositories\BaseRepository;

class BaseCrudRepository extends BaseRepository
{
    public function getModel()
    {
        return new BasesCrud();
    }
}