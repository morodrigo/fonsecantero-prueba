<?php


require_once __DIR__ . '/../Models/User.php';

class UserController
{
    //para mostrar el formulario de login e iniciar sesión
    public function showLoginForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username = htmlspecialchars(trim($_POST['username']));
                $password = htmlspecialchars(trim($_POST['password']));
                $user = User::authenticate($username, $password);
                if ($user) {
                  
                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['username'] = $user->getUsername();
                    $res = (['success' => true]);

                    header("Location: " . BASE_URL . "/tasks");
                    exit();
                } else {
                    $res = (['success' => false, 'message' => 'Usuario o Contraseña incorrectos']);
                }
            } else {
                $res = (['success' => false, 'message' => 'Favor de enviar usuario y contraseña']);
            }
        }
        $content = __DIR__ . '/../Views/auth/login.php';
        include __DIR__ . '/../Views/auth/layout.php';
    }
    
    //para mostrar el formulario de registrar usuarios y procesar dicha información
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
            if (isset($_POST['username'], $_POST['password'], $_POST['confirm_password'])) {
                if($_POST['confirm_password']!= $_POST['password']){
                    $res = (['success' => false, 'message' => 'Contraseña y confirmación no coinciden']); 
                }
                $user = new User();
                $username = htmlspecialchars(trim($_POST['username']));
                $password = htmlspecialchars(trim($_POST['password']));
                $result = $user->save($username, $password, date('Y-m-d H:i:s'));
                if ($result['success']) {
                    $res = (['success' => true, 'message' => '']);
                    $user2 = User::authenticate($username, $password);
                    $_SESSION['user_id'] = $user2->getId();
                    $_SESSION['username'] = $user2->getUsername();
                    header("Location: " . BASE_URL . "/tasks");
                    exit();
                } else {
                    $res = (['success' => false, 'message' => $result['message']]);
                }
            } else {
                $res = (['success' => false, 'message' => 'Faltan datos']);
            }
        }
        $content = __DIR__ . '/../Views/auth/register.php';
        include __DIR__ . '/../Views/auth/layout.php';
    }

    //para cerrar sesión
    public function logout()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        header("Location: ". BASE_URL."/login");
        exit();
    }
    
}
