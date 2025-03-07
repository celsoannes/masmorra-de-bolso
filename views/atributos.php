<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../views/login.php");
    exit;
}

$stmt = $pdo->query("SELECT ca.*, c.nome AS categoria_nome FROM categoria_atributos ca JOIN categorias c ON ca.categoria_id = c.id ORDER BY ca.categoria_id ASC, ca.nome_atributo ASC");
$atributos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Atributos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 pt-5">
        <h2>Lista de Atributos</h2>
        <a href="../controllers/adicionar_atributo.php" class="btn btn-success mb-3">Adicionar Atributo</a>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoria</th>
                    <th>Nome do Atributo</th>
                    <th>Tipo</th>
                    <th>Opções</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($atributos as $atributo): ?>
                    <tr>
                        <td><?= $atributo['id'] ?></td>
                        <td><?= htmlspecialchars($atributo['categoria_nome']) ?></td>
                        <td><?= htmlspecialchars($atributo['nome_atributo']) ?></td>
                        <td><?= htmlspecialchars($atributo['tipo_atributo']) ?></td>
                        <td><?= htmlspecialchars($atributo['opcoes']) ?></td>
                        <td>
                            <a href="../controllers/editar_atributo.php?id=<?= $atributo['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botão para abrir o modal de confirmação -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-bs-id="<?= $atributo['id'] ?>">
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
                    Tem certeza que deseja excluir este atributo?
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
        // Configura o modal para passar o ID do atributo a ser excluído
        const confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
        confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-bs-id'); // Extrai o ID do atributo
            const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');

            // Atualiza o link de exclusão com o ID do atributo
            btnConfirmarExclusao.href = `../controllers/excluir_atributo.php?id=${id}`;
        });
    </script>
</body>
</html>