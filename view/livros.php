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
    <label for="image">Imagem:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required><br>

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
                        <th>Imagem</th>

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
    // Verifica se há dados de imagem
    if (!empty($livro['image_data']) && !empty($livro['image_type'])) {
        $imageData = base64_encode($livro['image_data']);
        $imageType = $livro['image_type'];
        $imageSrc = "data:{$imageType};base64,{$imageData}";

        // Exibe a imagem usando a tag img
        echo '<td><img src="' . $imageSrc . '" alt="Imagem do Livro"  style="max-width: 70px; max-height: 70px;"></td>';
    } else {
        echo '<td>Sem imagem</td>';
    }
  
  
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


    const bookForm = document.getElementById('addBookForm');

bookForm.addEventListener('submit', async function (event) {
    event.preventDefault();

    try {
        const formData = new FormData(bookForm);
        const response = await fetch('create_book.php', {
            method: 'POST',
            body: formData,
        });

        if (response.ok) {
            const result = await response.json();

            if (result.status === 'success') {
                // Ocultar o modal
                const addBookModal = new bootstrap.Modal(document.getElementById('addBookModal'));
                addBookModal.hide();

                // Exibir a mensagem de sucesso
                Swal.fire({
                    icon: 'success',
                    title: 'Livro criado com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });

                // Recarregar a lista de livros (substitua o código abaixo com a lógica real para atualizar a lista)
                location.reload(); // Isso recarregará a página inteira; você pode querer usar uma abordagem mais eficiente, como AJAX, para carregar apenas os novos dados.

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro na criação',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        } else {
            console.error('Erro na requisição:', response.statusText);
        }
    } catch (error) {
        console.error('Erro:', error);
    }
});

}
    </script>
</body>
</html>
