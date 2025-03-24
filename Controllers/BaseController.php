<?php

class BaseController
{
    /**
     * Helper function to render a view.
     *
     * @param string $view The view file to render.
     * @param array $data The data to pass to the view.
     */
    // protected function view($view, $data = [])
    // {
    //     extract($data);
    //     ob_start();

    //     require "views/{$view}.php";
    //     $content = ob_get_clean();
    //     require "views/layout.php";
    // }

    /**
     * Helper function to handle redirections.
     *
     * @param string $url The URL to redirect to.
     */
    // protected function redirect($url)
    // {
    //     header("Location: $url");
    //     exit;
    // }

 

   /**
     * Helper function to render a view.
     *
     * @param string $view The view file to render.
     * @param array $data The data to pass to the view.
     */
    protected function view($view, $data = [])
    {
        // Use an absolute path relative to the project root
        $viewPath = dirname(__DIR__) . "/Views/" . $view . ".php";
        $layoutPath = dirname(__DIR__) . "/Views/layout.php";

        // Check if the view file exists
        if (!file_exists($viewPath)) {
            die("View file not found: " . $viewPath);
        }

        // Check if the layout file exists
        if (!file_exists($layoutPath)) {
            die("Layout file not found: " . $layoutPath);
        }

        extract($data);
        ob_start();

        require $viewPath;
        $content = ob_get_clean();
        require $layoutPath;
    }

    /**
     * Helper function to handle redirections.
     *
     * @param string $url The URL to redirect to.
     */
    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}