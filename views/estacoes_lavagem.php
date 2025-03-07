<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Modifique a query SQL para buscar os tempos de lavagem e cura
$stmt = $pdo->query("SELECT estacoes_lavagem.*, lavagem.Produto AS nome_lavagem FROM estacoes_lavagem LEFT JOIN lavagem ON estacoes_lavagem.lavagem_id = lavagem.id");
$estacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estações de Lavagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 pt-5">
        <h2>Lista de Estações de Lavagem</h2>
        <a href="../controllers/adicionar_estacao.php" class="btn btn-success mb-3">Adicionar Estação</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Localização</th>
                    <th>Data de Aquisição</th>
                    <th>Valor do Bem (R$)</th>
                    <th>Tempo de Vida Útil (h)</th>
                    <th>Tempo de Lavagem</th>
                    <th>Tempo de Cura</th>
                    <th>Consumo (kWh)</th>
                    <th>Lavagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estacoes as $estacao): ?>
                    <tr>
                        <td><?= htmlspecialchars($estacao['Marca']) ?></td>
                        <td><?= htmlspecialchars($estacao['Modelo']) ?></td>
                        <td><?= htmlspecialchars($estacao['Localizacao']) ?></td>
                        <td><?= date('d/m/Y', strtotime($estacao['Data_Aquisicao'])) ?></td>
                        <td>R$ <?= number_format($estacao['Valor_do_Bem'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($estacao['Tempo_de_Vida_Util']) ?></td>
                        <td><?= htmlspecialchars($estacao['tempo_lavagem']) ?></td>
                        <td><?= htmlspecialchars($estacao['tempo_cura']) ?></td>
                        <td><?= htmlspecialchars($estacao['kWh']) ?></td>
                        <td><?= htmlspecialchars($estacao['nome_lavagem']) ?></td>
                        <td>
                            <a href="../controllers/editar_estacao.php?id=<?= $estacao['ID'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botão para abrir o modal de confirmação -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-bs-id="<?= $estacao['ID'] ?>">
                                Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="confirmarExclusaoModal" tabindex="-1" aria-labelledby="confirmarExclusaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarExclusaoModalLabel">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir esta estação de lavagem?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="btnConfirmarExclusao" href="#" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts do Bootstrap e JavaScript personalizado -->
    <script>
        // Configura o modal para passar o ID da estação de lavagem a ser excluída
        const confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
        confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-bs-id'); // Extrai o ID da estação de lavagem
            const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');

            // Atualiza o link de exclusão com o ID da estação de lavagem
            btnConfirmarExclusao.href = `../controllers/excluir_estacao.php?id=${id}`;
        });
    </script>
</body>
</html>