<?php
include_once(__DIR__."/../model/Book.php");

// Recebe o ID do livro a ser excluído
$bookId = $_POST['bookId'];

$book = new Book();

try {
    // Chama a função delete_book da classe Book
    $result = $book->delete_book($bookId);

    // Retorna o resultado como JSON para a função JavaScript
    echo json_encode(['status' => 'success', 'message' => 'Livro excluído com sucesso']);
} catch (Exception $e) {
    // Em caso de erro, retorna uma mensagem de erro
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
