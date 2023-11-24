<?php
include_once(__DIR__."/../model/User.php");
include_once(__DIR__."/../model/Database.php");

class Auth {  
    public static function login($login, $password) {
        $Crud = new Crud();
        $where = 'login = :login';
        $bind = [':login' => $login];
    
        $users = $Crud->read('user', $where, $bind);
    
        if (!empty($users)) {
            $user = $users[0]; // Pega o primeiro usuário (deve haver apenas um)
    
            // Verifica a senha diretamente
            if ($user['password'] == $password) {
                return ['status' => 'success', 'message' => 'Login bem-sucedido'];
            } else {
                return ['status' => 'error', 'message' => 'Login mal-sucedido'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Usuário inexistente no sistema'];
        }
    }

    public static function token_login($token){
        if ( empty($token) )
        return ['status' => 'error', 'message' => 'Não foi possível efetuar o login de usuário, token inválido'];

        $User = new User();
        $login = $User->list(["api_token" => $token,  "limit" => 1]);
        if ( !$login ){ 
            sleep(5);
            return ['status' => 'error', 'message' => 'Token inválido'];
        }

  return self::create_session($login);
    }

    private static function create_session($user) {
if(!isset($_SESSION)) session_start();


        $_SESSION['auth'] = [
            'user_id' => $user['id'],
            'user_name' => $user['name'],
        ];

        return $_SESSION['auth'];
    }

	public static function logout(){
        session_destroy();
        unset($_SESSION);
        return [ "authenticated" => false ];

    }

    public static function get_auth_info(){
        return ( isset($_SESSION['auth']) ? $_SESSION['auth'] : [] );
      }
}
?>
