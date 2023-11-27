<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<!-- Adicionando o Bootstrap via CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Adicionando o SweetAlert via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        #app {
            display: flex;
            height: 100vh;
        }

        #sidebar {
            width: 240px;
            padding: 20px;
            background-color: rgb(248, 242, 253);
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
        }

        #content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        #bookContainer {
            margin-top: 40px;
        }

        #addBookBtn {
            margin-bottom: 20px;
            position: fixed;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <div id="app">
        <div id="sidebar">
            <?php include '../sidebar.php'; ?>
        </div>

        <div id="content">
            <div id="bookContainer">
                <h1 class="text-center">Lista de Livros</h1>

                <!-- Utilizando classes do Bootstrap para estilizar o botão -->
                <button id="addBookBtn" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBookModal">Adicionar Livro</button>

                <!-- Modal para adicionar um novo livro -->
             <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Adicionar Livro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="addBookForm">
    <label for="name">Nome:</label>
    <input type="text" class="form-control" id="name" name="name" required><br>

    <label for="author">Autor:</label>
    <input type="text" class="form-control" id="author" name="author" required><br>

    <label for="genre">Gênero:</label>
    <input type="text" class="form-control" id="genre" name="genre" required><br>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
            </div>
        </div>
    </div>
</div>

<script>
const bookForm = document.getElementById('addBookForm');

bookForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData(bookForm);
    const response = await fetch('create_book.php', {
        method: 'POST',
        body: formData,
    });

    const result = await response.json();

    if (result.status === 'success') {
        Swal.fire({
            icon: 'success',
            title: 'Livro criado com sucesso!',
            showConfirmButton: false,
            timer: 2000
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Erro na criação',
            text: result.message,
            showConfirmButton: false,
            timer: 2000
        });
    }
});
</script>

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Autor</th>
                            <th>Gênero</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
include_once(__DIR__."/../model/Book.php");

$livro = new Book(); 

$livros = $livro->list_books();
foreach ($livros as $livro) {
    echo '<tr>';
    echo '<td>' . $livro['id'] . '</td>';
    echo '<td>' . $livro['name'] . '</td>';
    echo '<td>' . $livro['author'] . '</td>';
    echo '<td>' . $livro['genre'] . '</td>';
    echo '</tr>';
}
?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Adicionando o Bootstrap JavaScript (popper.js incluído) via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
function addBook() {
    // Obtenha os valores do formulário
    var name = document.getElementById("name").value;
    var author = document.getElementById("author").value;
    var genre = document.getElementById("genre").value;

    // Crie um objeto FormData e adicione os dados do livro a ele
    var formData = new FormData();
    formData.append("name", name);
    formData.append("author", author);
    formData.append("genre", genre);
    // Adicione outros campos conforme necessário

const bookForm = document.getElementById('addBookForm');
console.log("Name:", name);
console.log("Author:", author);
console.log("Genre:", genre);

bookForm  .  addEventListener('submit', async function (event) {
                event.preventDefault();

                const formData = new FormData(bookForm);
                const response = await fetch('create_book.php', {
                    method: 'POST',
                    body: formData,
                });

                const result = await response.json();

                if (result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Livro criado com sucesso!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro na criação',
                        text: result.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });


    // Faça uma chamada AJAX para o backend
    // $.ajax({
    //     type: "POST",
    //     url: "../view/php/create_book.php", // Substitua pelo caminho correto
    //     data: formData,
    //     processData: false, // Evita que o jQuery processe os dados
    //     contentType: false, // Não defina automaticamente o cabeçalho Content-Type
    //     success: function (response) {
    //         // Verifique a resposta do backend
    //         if (response.success) {
    //             // Feche o modal de adição
    //             $('#addBookModal').modal('hide');

    //             // Exiba o modal de sucesso usando SweetAlert
    //             Swal.fire({
    //                 icon: 'success',
    //                 title: 'Livro Adicionado!',
    //                 showConfirmButton: false,
    //                 timer: 1500
    //             });

    //             // Atualize a tabela de livros (opcional)
    //             // Você pode recarregar os dados da tabela para exibir o novo livro
    //         } else {
    //             // Exiba uma mensagem de erro, se necessário
    //             console.error("Erro ao criar livro:", response.message);
    //         }
    //     },
    //     error: function (xhr, status, error) {
    //         // Log detalhes sobre o erro
    //         console.error("Erro ao fazer a requisição AJAX:");
    //         console.log("Status:", status);
    //         console.log("Error:", error);
    //         console.log("Response:", xhr.responseText);
    //     }
    // });
}


    </script>
</body>
</html>
