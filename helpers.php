<?php

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TemplateWrapper;

class Helpers
{
    private Environment $twig;

    /**
     * Set up twig environment
     */
    public function __construct()
    {
        $loader = new FilesystemLoader('../views/');
        $this->twig = new Environment($loader);

        // Add global session variable to pass to all twig templates
        $this->twig->addGlobal('session', $_SESSION);
    }

    /**
     * Display the given template using the array of variables passed
     *
     * @param string $template
     * @param array $variables
     * @return void
     */
    function displayTemplate(string $templateName, array $variables): void
    {
        $template = $this->twig->load($templateName);
        $template->display($variables);
        exit();
    }

    /**
     * Send user to error page
     * 
     * @param int $errorNumber
     * @param string $errorMessage
     * @return void
     */
    function error(int $errorNumber, string $errorMessage): void
    {
        $template = $this->twig->load('error.twig');
        $template->display([
            'errorNumber' => http_response_code($errorNumber),
            'errorMessage' => $errorMessage
        ]);
        exit();
    }
}
