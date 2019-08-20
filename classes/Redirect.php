<?php
class Redirect
{
    public static function to($location = null)
    {
        if (is_numeric($location)) {
            switch ($location) {
                case 404:
                    header('HTTP/1.0 4040 Not Found');
                    include 'includes/errors/404.php';
                    exit();
                    break;
            }
        }
        if ($location) {
            header('Location: ' . $location);
            exit();
        }
    }
}
