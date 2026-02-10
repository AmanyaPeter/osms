<?php
namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController {
    public function loginForm() {
        $this->sessionStart();
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
        }
        $this->view('auth/login');
    }

    public function login() {
        $this->verifyCsrfToken();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $this->sessionStart();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            $this->redirect('/');
        } else {
            $this->view('auth/login', ['error' => 'Invalid username or password']);
        }
    }

    public function logout() {
        $this->sessionStart();
        session_destroy();
        $this->redirect('/login');
    }
}
