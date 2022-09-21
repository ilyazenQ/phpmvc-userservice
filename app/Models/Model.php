<?php

namespace App\Models;

use App\App;


abstract class Model
{

    public function __construct()
    {
        $this->db = App::db();
    }

}