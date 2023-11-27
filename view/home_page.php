<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Book Flow</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        #app {
            display: flex;
            height: 100vh;
        }

    

        #content {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        #logo {
            text-align: center;
            margin-bottom: 20px;
        }

        #logo img {
            width: 200px; /* Ajuste a largura conforme necessário */
            height: auto;
        }

        #sidebar {
            width: 240px;
            padding: 20px;
            background-color: rgb(248, 242, 253);
            border-right: 1px solid #dee2e6;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div id="app">
        <div id="sidebar">
            <?php include '../sidebar.php'; ?>
        </div>

        <div id="content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <!-- Conteúdo da Página -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Usuários Cadastrados no último mês
                        </div>
                        <canvas id="chart2" width="400" height="300"></canvas>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Maiores Categorias
                        </div>
                        <canvas id="chart1" width="400" height="300"></canvas>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Após a inclusão do Bootstrap e do Chart.js -->
<script>
    // Dados do primeiro gráfico
    var data1 = {
        labels: ['Categoria A', 'Categoria B', 'Categoria C'],
        datasets: [{
            label: 'Dados 1',
            data: [12, 19, 3], // Substitua isso pelos seus dados
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configurações do primeiro gráfico
    var options1 = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Criar o gráfico
    var ctx1 = document.getElementById('chart1').getContext('2d');
    var chart1 = new Chart(ctx1, {
        type: 'bar',
        data: data1,
        options: options1
    });

    // Dados do segundo gráfico
    var data2 = {
        labels: ['Categoria X', 'Categoria Y', 'Categoria Z'],
        datasets: [{
            label: 'Dados 2',
            data: [5, 10, 15], // Substitua isso pelos seus dados
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    };

    // Configurações do segundo gráfico
    var options2 = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Criar o segundo gráfico
    var ctx2 = document.getElementById('chart2').getContext('2d');
    var chart2 = new Chart(ctx2, {
        type: 'bar',
        data: data2,
        options: options2
    });
</script>

    <script src="https://kit.fontawesome.com/4571a5345a.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>