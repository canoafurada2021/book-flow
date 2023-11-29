<?php
    include_once(__DIR__."/../model/Book.php");

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $livro = new Book();
    
    // Certifique-se de validar e sanitizar os dados do formulário antes de usá-los
    if (isset($_POST['name'], $_POST['author'], $_POST['genre'])) {
        $name = trim($_POST['name']);
        $author = trim($_POST['author']);
        $genre = trim($_POST['genre']);

        // Verifique se os campos não estão vazios
        if (!empty($name) && !empty($author) && !empty($genre)) {
            try {
                // Verifique se uma imagem foi enviada
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    // Obtenha dados da imagem
                    $imageData = file_get_contents($_FILES['image']['tmp_name']);
                    $imageType = $_FILES['image']['type'];

                    // Defina os dados da imagem no objeto livro
                    $livro->set_imageData($imageData);
                    $livro->set_imageType($imageType);
                }

                // Crie o livro no banco de dados
                $result = $livro->create_book(['name' => $name, 'author' => $author, 'genre' => $genre, 'image_data'=> $imageData, 'image_type'=> $imageType]);

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
