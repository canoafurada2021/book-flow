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
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .bookCard {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
        }

        .bookImage {
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }

        #addBookBtn {
            margin-bottom: 20px;
            position: fixed;
            top: 20px;
            right: 20px;
        }
        #noBooksMessage {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div id="app">
        <div id="sidebar">
            <?php include '../sidebar.php'; ?>
        </div>

        <div id="content">
            <div class="mb-3">
                <input type="text" class="form-control" id="search" placeholder="Pesquisar">
            </div>

            <div id="bookContainer">

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
<select class="form-control" id="genre" name="genre" required>
    <option value="Ficção">Ficção</option>
    <option value="Não Ficção">Não Ficção</option>
    <option value="Romance">Romance</option>
    <!-- Adicione mais opções conforme necessário -->
</select><br>
    <label for="image">Imagem:</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required><br>

                <button type="submit" class="btn btn-primary" id="saveButton">Salvar</button>
</form>
            </div>
        </div>
    </div>


                </div>

                <?php
include_once(__DIR__."/../model/Book.php");

$livro = new Book(); 
$livros = $livro->list_books();

if (empty($livros)) {
    echo '<p>Nenhum livro cadastrado no sistema</p>';
} else {
    foreach ($livros as $livro) {
        echo '<div class="bookCard livro">';
        // Verifica se há dados de imagem
        if (!empty($livro['image_data']) && !empty($livro['image_type'])) {
            $imageData = base64_encode($livro['image_data']);
            $imageType = $livro['image_type'];
            $imageSrc = "data:{$imageType};base64,{$imageData}";
    
            // Exibe a imagem usando a tag img
            echo '<img class="bookImage" src="' . $imageSrc . '" alt="Imagem do Livro">';
        } else {
            echo '<p>Sem imagem</p>';
        }
    
        echo '<h5 class="title">' . $livro['name'] . '</h5>';
        echo '<p class="author">Autor: ' . $livro['author'] . '</p>';
        echo '<p class="genre">Gênero: ' . $livro['genre'] . '</p>';
        echo '<div class="bookButtons">';
        echo '<button class="btn btn-primary" onclick="editBook(' . $livro['id'] . ')"><i class="fas fa-edit"></i></button>';
        echo '<button class="btn btn-danger" onclick="confirmDeleteBook(' . $livro['id'] . ')"><i class="fas fa-trash-alt"></i></button>';
        echo '</div>';
        echo '</div>';
    }
}
?>

            </div>
        </div>
    </div>

<script>
function editBook(bookId) {
    // Chama a função para obter detalhes do livro pelo ID
    fetch('get_book_details.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'bookId': bookId,
        }),
    })
    .then(response => response.json())
    .then(data => {
        // Exibe um modal de edição com os detalhes do livro
        if (data.status === 'success') {
            const bookDetails = data.book;
            openEditModal(bookDetails);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Erro na obtenção de detalhes do livro',
                text: data.message,
            });
        }
    })
    .catch(error => {
        console.error('Erro na requisição AJAX:', error);
    });
}



// Função para exclusão de livro
function confirmDeleteBook(bookId) {
        // Chama a função de exclusão do livro no lado do servidor
        fetch('delete_book.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                'bookId': bookId,
            }),
        })
        .then(response => response.json())
        .then(data => {
            // Exibe uma mensagem de sucesso ou erro
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Livro excluído com sucesso!',
                    showConfirmButton: false,
                    timer: 2000
                });

                setTimeout(() => {
            // Recarregar a lista de livros (substitua o código abaixo com a lógica real para atualizar a lista)
            // Isso recarregará a página inteira; você pode querer usar uma abordagem mais eficiente, como AJAX, para carregar apenas os novos dados.
            location.reload();
        }, 2000);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro na exclusão',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        })
        .catch(error => {
            console.error('Erro na requisição AJAX:', error);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search');
            const livros = document.querySelectorAll('.livro');

            searchInput.addEventListener('input', function () {
                const searchValue = searchInput.value.toLowerCase();

                livros.forEach(function (livro) {
                    const title = livro.querySelector('h5').innerText.toLowerCase();
                    const author = livro.querySelector('.author').innerText.toLowerCase();
                    const genre = livro.querySelector('.genre').innerText.toLowerCase();

                    // Verifica se qualquer um dos campos corresponde à pesquisa
                    const isMatch = title.includes(searchValue) || author.includes(searchValue) || genre.includes(searchValue);

                    // Adiciona ou remove a classe "hidden" com base na correspondência da pesquisa
                    livro.classList.toggle('hidden', !isMatch);
                });
            });
        });

document.addEventListener('DOMContentLoaded', function () {

        // Adiciona a função addBook ao evento de clique do botão Salvar
        const saveButton = document.getElementById('saveButton');
        saveButton.addEventListener('click', addBook);
    });

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

    // Ocultar o modal de criação de livro
    const addBookModal = new bootstrap.Modal(document.getElementById('addBookModal'));
    addBookModal.hide();

    if (result.status === 'success') {
        // Exibir a mensagem de sucesso
        Swal.fire({
            icon: 'success',
            title: 'Livro criado com sucesso!',
            showConfirmButton: false,
            timer: 2000
        });

        // Atraso de 2 segundos antes de recarregar a página
        setTimeout(() => {
            // Recarregar a lista de livros (substitua o código abaixo com a lógica real para atualizar a lista)
            // Isso recarregará a página inteira; você pode querer usar uma abordagem mais eficiente, como AJAX, para carregar apenas os novos dados.
            location.reload();
        }, 2000);
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
    <script src="https://kit.fontawesome.com/4571a5345a.js" crossorigin="anonymous"></script>

    <!-- Adicionando o Bootstrap JavaScript (popper.js incluído) via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ... (seu script JavaScript existente) ... -->
</body>
</html>
