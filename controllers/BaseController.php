<?php

namespace App\Controllers;

use RedBeanPHP\R;

class BaseController
{
    public function __construct()
    {
        if (!R::testConnection()) {
            R::setup('mysql:host=localhost;dbname=fullstack_framework', 'bit_academy', 'bit_academy');
        }
    }

    public function getBeanById($typeOfBean, $queryStringKey)
    {
        if (!R::find($typeOfBean, "id = $queryStringKey")) {
            return;
        }

        $bean = R::load($typeOfBean, $queryStringKey);

        return $bean;
    }
}
