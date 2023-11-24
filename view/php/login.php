<?php


include_once(__DIR__."/../model/Database.php");
include_once(__DIR__."/../model/User.php");

include_once(__DIR__."/../configs/Auth.php");

$dsn = "mysql:host=localhost;dbname=book_flow;charset=utf8mb4";
$username = "root";
$password = "";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];




$conn = new Database($dsn, $username, $password, $options);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    

    $login = isset($_POST['login']) ? $_POST['login'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    try {
        // Tenta fazer o login
        Auth::login($login, $password);

        // Se chegar aqui, o login foi bem-sucedido
        echo 'Login efetuado com sucesso!';
    } catch (AuthException $e) {
        // Se ocorrer uma exceção, o login falhou
        echo 'Erro no login: ' . $e->getMessage();
    }
}
?>