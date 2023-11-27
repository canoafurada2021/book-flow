<?php
    include_once(__DIR__."/../model/Book.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Certifique-se de incluir sua classe Book aqui

    $livro = new Book();
    
    // Certifique-se de validar e sanitizar os dados do formulário antes de usá-los
    if (isset($_POST['name'], $_POST['author'], $_POST['genre'])) {
        $name = trim($_POST['name']);
        $author = trim($_POST['author']);
        $genre = trim($_POST['genre']);

        echo 'Name: ' . $name . '<br>';
        echo 'Author: ' . $author . '<br>';
        echo 'Genre: ' . $genre . '<br>';
        // Verifique se os campos não estão vazios
        if (!empty($name) && !empty($author) && !empty($genre)) {
            try {
                $result = $livro->create_book(['name' => $name, 'author' => $author, 'genre' => $genre]);

                echo $result;
                if ($result) {
                    // Se a criação for bem-sucedida, envie uma resposta de sucesso
                    echo json_encode(['status' => 'success']);
                } else {
                    // Se houver um erro ao criar o livro, envie uma resposta de erro
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao criar livro']);
                }
            } catch (Exception $e) {
                // Se ocorrer uma exceção, envie uma resposta de erro
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
        } else {
            // Se algum dos campos estiver vazio, envie uma resposta de erro
            echo json_encode(['status' => 'error', 'message' => 'Preencha todos os campos do livro']);
        }
    } else {
        // Se algum dos campos não estiver definido, envie uma resposta de erro
        echo json_encode(['status' => 'error', 'message' => 'Dados do livro incompletos']);
    }
}
?>
