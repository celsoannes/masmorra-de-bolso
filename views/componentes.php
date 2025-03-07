<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

// Buscar todos os componentes
$componentes = $pdo->query("SELECT * FROM componentes ORDER BY nome_material")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Componentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 pt-5">
        <h2>Lista de Componentes</h2>
        <a href="../controllers/adicionar_componente.php" class="btn btn-success mb-3">Adicionar Componente</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Unidade</th>
                    <th>Preço Unitário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($componentes as $componente): ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($componente['caminho_imagem']) ?>" alt="Imagem da peça" class="img-thumbnail" width="80"></td>
                        <td><?= htmlspecialchars($componente['nome_material']) ?></td>
                        <td><?= htmlspecialchars($componente['tipo_material']) ?></td>
                        <td><?= htmlspecialchars($componente['unidade_medida']) ?></td>
                        <td>R$ <?= number_format($componente['preco_unitario'], 2, ',', '.') ?></td>
                        <td>
                            <a href="../controllers/editar_componente.php?id=<?= $componente['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botão para abrir o modal de confirmação -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-bs-id="<?= $componente['id'] ?>">
                                Excluir
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary">Voltar ao Menu</a>
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
                    Tem certeza que deseja excluir este componente?
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
        // Configura o modal para passar o ID do componente a ser excluído
        const confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
        confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-bs-id'); // Extrai o ID do componente
            const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');

            // Atualiza o link de exclusão com o ID do componente
            btnConfirmarExclusao.href = `../controllers/excluir_componente.php?id=${id}`;
        });
    </script>
</body>
</html>