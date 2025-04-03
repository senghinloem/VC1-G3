<?php
class BaseController
{
    /**
     * Helper function to render a view.
     *
     * @param string $view The view file to render (e.g., 'auth/login').
     * @param array $data The data to pass to the view.
     * @param bool $useLayout Whether to use the layout or not.
     */
    protected function view($view, $data = [], $useLayout = true)
    {
        extract($data);
        ob_start();

        // Resolve the view path relative to the views directory
        $viewPath = __DIR__ . "/../views/{$view}.php";
        if (!file_exists($viewPath)) {
            die("View file not found: " . $viewPath);
        }

        require $viewPath;
        $content = ob_get_clean();

        if ($useLayout) {
            // Include the layout
            $layoutPath = __DIR__ . "/../views/layout.php";
            if (!file_exists($layoutPath)) {
                die("Layout file not found: " . $layoutPath);
            }
            require $layoutPath;
        } else {
            // Output the content directly without a layout
            echo $content;
        }
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