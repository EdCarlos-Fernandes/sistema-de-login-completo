<?php
include('../_config/auth_check.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        .section-header {
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .card {
            margin-bottom: 20px;
        }
        .financial-summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .financial-summary div {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .chart-container {
            position: relative;
            height: 190px; /* Altura fixa para o gráfico */
            width: 100%;
        }
        #financialChart {
            height: 100%; /* Ajusta a altura do canvas para 100% do container */
            width: 100%; /* Ajusta a largura do canvas para 100% do container */
        }
        .modal-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- <a class="navbar-brand" href="#">Dashboard</a> -->
        <span class="navbar-text mr-3">Olá, <?php echo $username; ?></span>
        <div class="ml-auto">
            <a href="./logout.php" class="btn btn-danger">Sair</a>
        </div>
    </nav>

    <div class="container mt-5">
        <!-- Seção Visão Geral das Finanças -->
        <section class="d-flex justify-content-between section-header">
            <h2>Visão Geral das Finanças</h2>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addTransactionModal">Adicionar Transação</button>
        </section>

        <!-- Modal Adicionar Transação -->
        <div class="modal fade" id="addTransactionModal" tabindex="-1" role="dialog" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTransactionModalLabel">Adicionar Transação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                    <form id="transactionForm">
                        <div class="form-group">
                            <label for="transactionDate">Data</label>
                            <input type="date" class="form-control" id="transactionDate" name="transaction_date" required>
                        </div>
                        <div class="form-group">
                            <label for="transactionType">Tipo</label>
                            <select class="form-control" id="transactionType" name="transaction_type" required>
                                <option value="income">Receita</option>
                                <option value="expense">Despesa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="transactionValue">Valor</label>
                            <input type="number" class="form-control" id="transactionValue" name="transaction_value" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="transactionDescription">Descrição</label>
                            <textarea class="form-control" id="transactionDescription" name="transaction_description" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Transação</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- fim do Modal -->

        <section>
            <div class="mb-4">
                <div class="financial-summary">
                    <div>
                        <h5>Saldo Total</h5>
                        <p>R$ 1.234,56</p>
                    </div>
                    <div>
                        <h5>Receitas</h5>
                        <p>R$ 2.023,56</p>
                    </div>
                    <div>
                        <h5>Despesas</h5>
                        <p>R$ 789,00</p>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Gráfico de Receitas e Despesas</h5>
                    <div class="chart-container">
                        <canvas id="financialChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- Outras seções do dashboard -->
        <section class="section-header">
            <h2>Gerenciamento de Transações</h2>
        </section>
        <section class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Visualizar Transações</h5>
                        <p class="card-text">Aqui você pode listar e filtrar suas transações financeiras.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-header">
            <h2>Categorias de Despesas e Receitas</h2>
        </section>
        <section class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gerenciar Categorias</h5>
                        <button class="btn btn-secondary">Adicionar Categoria</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-header">
            <h2>Orçamentos e Metas</h2>
        </section>
        <section class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Criar Orçamentos</h5>
                        <button class="btn btn-info">Criar Orçamento</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Definir Metas Financeiras</h5>
                        <button class="btn btn-success">Definir Meta</button>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        var ctx = document.getElementById('financialChart').getContext('2d');
        var financialChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['01-01-2024', '02-01-2024', '03-01-2024', '04-01-2024', '05-01-2024', '06-01-2024'],
                datasets: [
                    {
                        label: 'Receitas',
                        data: [1200, 3500, 1700, 1600, 1800, 1900],
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: 'Despesas',
                        data: [800, 900, 950, 850, 1000, 1100],
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                if (label) {
                                    label += ': R$' + context.raw.toFixed(2);
                                }
                                return label;
                            }
                            
                        },
                        intersect: false, // Mostra o tooltip ao passar o mouse sobre qualquer parte da área do gráfico
                        mode: 'index' // Exibe as informações para todos os datasets ao passar o mouse
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Data'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valor'
                        }
                    }
                }
            }
        });

        
    </script>
    <script>
        $(document).ready(function() {
            $('#transactionForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '../_config/add_transaction.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        console.log('Resposta:', response); // Adicione isto para verificar a resposta
                        if (response.status === 'success') {
                            alert('Transação adicionada com sucesso!');
                            $('#addTransactionModal').modal('hide');
                            // Aqui você pode adicionar a lógica para atualizar a página ou a tabela de transações
                        } else {
                            alert('Erro: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Status:', status);
                        console.error('Error:', error);
                        alert('Erro na requisição.');
                    }
                });
            });
        });
    </script>


</body>
</html>
