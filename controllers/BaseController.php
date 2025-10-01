<?php

declare(strict_types=1);

namespace App\Controllers;

use RedBeanPHP\OODBBean;
use RedBeanPHP\R;

/**
 * BaseController connects to Database
 */
class BaseController
{
    /**
     * Sets up database connection
     */
    public function __construct()
    {
        if (!R::testConnection()) {
            R::setup('mysql:host=localhost;dbname=fullstack_framework', 'bit_academy', 'bit_academy');
        }
    }

    /**
     * Find and return Database Bean Object using id
     *
     * @param $typeOfBean
     * @param $queryStringKey
     * @return \RedBeanPHP\OODBBean|void
     */
    public function getBeanById($typeOfBean, $queryStringKey)
    {
        if (!R::find($typeOfBean, "id = $queryStringKey")) {
            return;
        }

        $bean = R::load($typeOfBean, $queryStringKey);

        return $bean;
    }

    public function authorizeUser(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /user/login');
            exit();
        }

        return;
    }
}
