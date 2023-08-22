<?php

namespace App\Models;

class Custom extends EbModel
{

    public function __construct()
    {
        parent::__construct();

        $this->request = \Config\Services::request();
    }


}
