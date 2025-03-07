<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM lavagem");
$lavagens = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos de Lavagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 pt-5">
        <h2>Lista de Produtos de Lavagem</h2>
        <a href="../controllers/adicionar_lavagem.php" class="btn btn-success mb-3">Adicionar Produto</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Valor por Litro (R$)</th>
                    <th>Fator de Consumo</th>
                    <th>Última Atualização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lavagens as $lavagem): ?>
                    <tr>
                        <td><?= htmlspecialchars($lavagem['Produto']) ?></td>
                        <td>R$ <?= number_format($lavagem['Valor_Litro'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($lavagem['Fator_Consumo']) ?></td>
                        <td><?= date('d/m/Y', strtotime($lavagem['Ultima_Atualizacao'])) ?></td>
                        <td>
                            <a href="../controllers/editar_lavagem.php?id=<?= $lavagem['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botão para abrir o modal de confirmação -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-bs-id="<?= $lavagem['id'] ?>">
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
                    Tem certeza que deseja excluir este produto de lavagem?
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
        // Configura o modal para passar o ID do produto de lavagem a ser excluído
        const confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
        confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-bs-id'); // Extrai o ID do produto de lavagem
            const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');

            // Atualiza o link de exclusão com o ID do produto de lavagem
            btnConfirmarExclusao.href = `../controllers/excluir_lavagem.php?id=${id}`;
        });
    </script>
</body>
</html>