<div id="sidebar">

    <style>
        /* Adicione seu CSS personalizado aqui */
        #logo {
            text-align: center;
            margin-bottom: 20px;
        }

        #logo img {
            width: 200px; /* Ajuste a largura conforme necessário */
            height: auto;
        }

        #title {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .nav-item {
            margin-bottom: 10px;
        }

        .nav-link {
            display: block;
            padding: 15px;
            border-radius: 20px; /* Adiciona cantos arredondados */
            transition: background-color 0.3s;
            color: rgb(67, 1, 108); /* Cor do texto */
        }

        .nav-link:hover {
            background-color: #f8f8f8; /* Altera a cor de fundo ao passar o mouse */
            border: 1px solid #ccc; /* Adiciona uma borda ao redor do item ao passar o mouse */
        }
    </style>

    <div id="logo">
        <img src="assets/images/nome.png" alt="Logo do Projeto">
    </div>
    <hr>
    <div id="title">
        <h5>Bem-vindo Pedro</h5>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="../view/home_page.php">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../view/livros.php">
                <i class="fa-solid fa-book"></i> Livros
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="..view/usuarios.php">
                <i class="fas fa-user"></i> Usuários
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa-solid fa-right-from-bracket"></i> Sair
            </a>
        </li>
    </ul>

</div>

