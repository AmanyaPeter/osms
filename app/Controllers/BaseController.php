<?php
namespace App\Controllers;

class BaseController {
    protected function view($view, $data = [], $layout = null) {
        $data['csrf_token'] = $this->generateCsrfToken();
        extract($data);
        if ($layout) {
            ob_start();
            require_once "../app/Views/{$view}.php";
            $content = ob_get_clean();
            require_once "../app/Views/layouts/{$layout}.php";
        } else {
            require_once "../app/Views/{$view}.php";
        }
    }

    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }

    protected function sessionStart() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function authCheck() {
        $this->sessionStart();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
    }

    protected function roleCheck($allowedRoles) {
        $this->authCheck();
        if (!in_array($_SESSION['role'], $allowedRoles)) {
            die("Unauthorized access.");
        }
    }

    protected function generateCsrfToken() {
        $this->sessionStart();
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrfToken() {
        $this->sessionStart();
        $token = $_POST['csrf_token'] ?? '';
        if (!$token || $token !== ($_SESSION['csrf_token'] ?? '')) {
            die("CSRF token validation failed.");
        }
    }
}
