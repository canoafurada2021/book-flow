<?php
header('Content-Type: application/json');

include_once(__DIR__."/../model/Database.php");
include_once(__DIR__."/../model/User.php");
include_once(__DIR__."/../model/Book.php");

 include_once(__DIR__."/../configs/Auth.php");


 // $dsn = "mysql:host=localhost;dbname=book_flow;charset=utf8mb4";
// $username = "root";
// $password = "";
// $options = [
//     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
// ];

// $conn = Database::getInstance($dsn, $username, $password, $options);
// Auth::setConnection($conn);

// if ($conn->getConnection()) {
//     echo 'conectado com sucesso';

//     $User = new User();

//     // Dados do usuário
//     $user_data = array(
//         'name' => 'Nome do Usuário',
//         'email' => 'usuario@example.com',
//         'login' => 'novousuario',
//         'password' => 'Senha123', 
//     );

//     // Setando os dados do usuário
//     $User->set_name($user_data['name']);
//     $User->set_email($user_data['email']);
//     $User->set_login($user_data['login']);
//     $User->set_password($user_data['password']);

//     // Criando o usuário no banco de dados
//     try {
//         $User->create_user($conn);
//         echo 'Usuário criado com sucesso!';
//     } catch (Exception $e) {
//         echo 'Erro ao criar usuário: ' . $e->getMessage();
//     }

// } else {
//     echo 'erro ao conectar';
// }
//$user = $User->get_user_by_credentials($conn->getConnection(), $login, $password);



// $User = new User();

// // Dados do usuário
// $user_data = array(
//     'name' => 'Nome do Usuário',
//     'email' => 'usuario@example.com',
//     'login' => 'tamires Pauli',
//     'password' => 'Comando7028!', 
// );

// // Setando os dados do usuário
// $User->set_name($user_data['name']);
// $User->set_email($user_data['email']);
// $User->set_login($user_data['login']);

// $hashed_password = password_hash($user_data['password'], PASSWORD_DEFAULT);
// $User->set_password($hashed_password);

// // Criando o usuário no banco de dados

// // Criando e atribuindo o api_token
// $api_token = $User->create_api_token($user_data['login'], $user_data['password']);
// $User->set_api_token($api_token);
//   $User->create_user();

// $Book = new Book();

// $book_data = array(
// 'name' => 'Memorias Póstumas de Brás Cubas',
// 'author' => 'Machado de Assis',
// 'genre' => 'Romance',
// );

// $Book-> set_name($book_data['name']);
// $Book-> set_author($book_data['author']);
// $Book-> set_genre($book_data['genre']);
// $Book-> create_book();


$response = ['status' => 'error', 'message' => 'Ocorreu um erro no login.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        $authResponse = Auth::login($login, $password);
        $response = $authResponse;
    } catch (AuthException $e) {
        $response['message'] = $e->getMessage();
    }

 
}

http_response_code(200);
echo json_encode($response);

?>






