<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT p.*, e.nome AS estudio_nome, i.modelo AS impressora_nome 
                     FROM pecas p 
                     INNER JOIN estudios e ON p.estudio_id = e.id
                     INNER JOIN impressoras i ON p.impressora = i.id
                     ORDER BY p.nome");

$pecas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Peças 3D</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 pt-5">
        <h2>Lista de Peças 3D</h2>
        <a href="../controllers/adicionar_peca.php" class="btn btn-success mb-3">Adicionar Peça</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Estúdio</th>
                    <th>Nome Original</th>
                    <th>Nome do Arquivo</th>
                    <th>Impressora</th>
                    <th>Material</th>
                    <th>Qtd. Material (g)</th>
                    <th>Tempo Impressão</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pecas as $peca): ?>
                    <tr>
                        <td>
                            <?php if (!empty($peca['imagem'])): ?>
                                <img src="/<?= htmlspecialchars($peca['imagem']) ?>" alt="Imagem da peça" class="img-thumbnail" width="80">
                            <?php else: ?>
                                <span>Sem imagem</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($peca['nome']) ?></td>
                        <td><?= htmlspecialchars($peca['estudio_nome']) ?></td>
                        <td><?= htmlspecialchars($peca['nome_original']) ?></td>
                        <td><?= htmlspecialchars($peca['nome_arquivo']) ?></td>
                        <td><?= htmlspecialchars($peca['impressora_nome']) ?></td>
                        <td><?= htmlspecialchars($peca['material']) ?></td>
                        <td><?= htmlspecialchars($peca['quantidade_material']) ?></td>
                        <td><?= htmlspecialchars($peca['tempo_impressao']) ?></td>
                        <td>
                            <a href="/controllers/editar_peca.php?id=<?= $peca['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botão para abrir o modal de confirmação -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-bs-id="<?= $peca['id'] ?>">
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
                    Tem certeza que deseja excluir esta peça?
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
        // Configura o modal para passar o ID da peça a ser excluída
        const confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
        confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-bs-id'); // Extrai o ID da peça
            const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');

            // Atualiza o link de exclusão com o ID da peça
            btnConfirmarExclusao.href = `/controllers/excluir_peca.php?id=${id}`;
        });
    </script>
</body>
</html>