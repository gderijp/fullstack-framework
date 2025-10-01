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
        $foundUser = R::findOne('user', "username = ?", [
            [$user, PDO::PARAM_STR],
        ]);

        // send user back to form if no user is found
        if (!$foundUser || !$this->verifyUser($pass, $foundUser['password'])) {
            $_SESSION['login_error'] = 'Invalid username or password';
            $this->login();
            exit();
        }

        // send user to index page
        $_SESSION['user_id'] = $foundUser['id'];
        $_SESSION['username'] = $foundUser['username'];
        header('Location: /recipe');
        exit();
    }

    /**
     * Show register template
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function register(): void
    {
        $errorMessage = null;
        if (isset($_SESSION['register_error'])) {
            $errorMessage = $_SESSION['register_error'];
            unset($_SESSION['register_error']);
        }

        $this->helper->displayTemplate('user/register.twig', [
            'errorMessage' => $errorMessage,
        ]);
    }

    /**
     * Checks if user filled in all fields
     *
     * Throw error if username exists
     *
     * Logs in and send user to index page if there's a match
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function registerPost(): void
    {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $passVerify = $_POST['verify_pass'];

        if (empty($user) || empty($pass) || empty($passVerify)) {
            $_SESSION['register_error'] = 'All fields are required';
            $this->register();
            exit();
        }

        if ($pass !== $passVerify) {
            $_SESSION['register_error'] = 'Passwords did not match';
            $this->register();
            exit();
        }


        $userExists = R::find('user', "username = ?", [
            [$user, PDO::PARAM_STR]
        ]);

        // send user back to form if username already exists
        if ($userExists) {
            $_SESSION['register_error'] = 'Username is already in use';
            $this->register();
            exit();
        }

        $_SESSION['user_id'] = $this->addUserToDatabase($user, $pass);
        $_SESSION['username'] = $user;
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

    /**
     * Verify if password_verify fails or succeds
     * 
     * @param string $pass
     * @param string $hash
     * @return bool
     */
    private function verifyUser(string $pass, string $hash): bool
    {
        if (password_verify($pass, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Adds user to database
     * 
     * returns the id of the user added
     * 
     * @param string $username
     * @param string $password
     * @return int
     */
    private function addUserToDatabase(string $username, string $password): int
    {
        $newUser = R::dispense('user');

        $newUser->username = $username;
        $newUser->password = password_hash($password, PASSWORD_BCRYPT);

        return R::store($newUser);
    }
}
