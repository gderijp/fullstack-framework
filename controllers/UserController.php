<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Helpers;
use App\Controllers\BaseController;
use PDO;
use RedBeanPHP\R;

/**
 *  Controller for all the recipes found in the database
 */
class UserController extends BaseController
{
    private Helpers $helper;

    public function __construct()
    {
        // set up connection to db
        parent::__construct();

        $this->helper = new Helpers();
    }

    /**
     * If user doesn't specify a second slug, show login page
     *
     * @return void
     */
    public function index(): void
    {
        $this->login();
    }

    /**
     * Show login template
     *
     * @return void
     */
    public function login(): void
    {
        $errorMessage = null;
        if (isset($_SESSION['login_error'])) {
            $errorMessage = $_SESSION['login_error'];
            unset($_SESSION['login_error']);
        }

        $this->helper->displayTemplate('user/login.twig', [
            'errorMessage' => $errorMessage,
        ]);
    }

    /**
     * Searches for user with given username
     * If username exists, checks if passwords match
     *
     * Send user to login form with error if there is no match
     *
     * Send user to index page if there's a match
     *
     * @return void
     */
    public function loginPost(): void
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $foundUser = R::find('user', "username = ?", [
            [$user, PDO::PARAM_STR],
        ]);

        // send user back to form if no user is found
        if (!$foundUser || !$this->verifyUser($pass, $foundUser[1]['password'])) {
            $_SESSION['login_error'] = 'Invalid username or password';
            $this->login();
            exit();
        }

        // send user to index page
        $_SESSION['user_id'] = $foundUser[1]['id'];
        $_SESSION['username'] = $foundUser[1]['username'];
        header('Location: /recipe');
        exit();
    }

    /**
     * user gets logged out if user visits '/user/logout'
     *
     * Sends back to login page after logging out
     *
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user_id']);
        header('Location: /user/login');
    }

    private function verifyUser(string $pass, string $hash): bool
    {
        if (password_verify($pass, $hash)) {
            return true;
        } else {
            return false;
        }
    }
}
