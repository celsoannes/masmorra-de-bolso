<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM impressoras");
$impressoras = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Impressoras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 pt-5">
        <h2>Lista de Impressoras</h2>
        <a href="../controllers/adicionar_impressora.php" class="btn btn-success mb-3">Adicionar Impressora</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Tipo</th>
                    <th>Localização</th>
                    <th>Data de Aquisição</th>
                    <th>Valor do Bem (R$)</th>
                    <th>Tempo de Vida Útil (horas)</th>
                    <th>Consumo de Energia (kWh)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($impressoras as $impressora): ?>
                    <tr>
                        <td><?= htmlspecialchars($impressora['Marca']) ?></td>
                        <td><?= htmlspecialchars($impressora['Modelo']) ?></td>
                        <td><?= htmlspecialchars($impressora['Tipo']) ?></td>
                        <td><?= htmlspecialchars($impressora['Localizacao']) ?></td>
                        <td><?= date("d/m/Y", strtotime($impressora['Data_Aquisicao'])) ?></td>
                        <td>R$ <?= number_format($impressora['Valor_do_Bem'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($impressora['Tempo_de_Vida_Util']) ?> horas</td>
                        <td><?= number_format($impressora['kWh'], 3, ',', '.') ?> kWh</td>
                        <td>
                            <a href="../controllers/editar_impressora.php?id=<?= $impressora['ID'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botão para abrir o modal de confirmação -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-bs-id="<?= $impressora['ID'] ?>">
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
                    Tem certeza que deseja excluir esta impressora?
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
        // Configura o modal para passar o ID da impressora a ser excluída
        const confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
        confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-bs-id'); // Extrai o ID da impressora
            const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');

            // Atualiza o link de exclusão com o ID da impressora
            btnConfirmarExclusao.href = `../controllers/excluir_impressora.php?id=${id}`;
        });
    </script>
</body>
</html>