<?php
session_start();
require __DIR__ . '/../config/config.php';
require __DIR__ . '/../includes/menu.php';

$stmt = $pdo->query("SELECT * FROM tabela_energia");
$energias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarifas de Energia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4 pt-5">
        <h2>Lista de Tarifas de Energia</h2>
        <a href="../controllers/adicionar_energia.php" class="btn btn-success mb-3">Adicionar Tarifa</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Prestadora</th>
                    <th>kWh (R$)</th>
                    <th>ICMS (%)</th>
                    <th>PIS/PASEP (%)</th>
                    <th>COFINS (%)</th>
                    <th>Total/hora (R$)</th>
                    <th>Última Atualização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($energias as $energia): ?>
                    <tr>
                        <td><?= htmlspecialchars($energia['Prestadora']) ?></td>
                        <td><?= number_format($energia['kWh'], 2, ',', '.') ?></td>
                        <td><?= number_format($energia['ICMS'], 2, ',', '.') ?></td>
                        <td><?= number_format($energia['PIS_PASEP'], 2, ',', '.') ?></td>
                        <td><?= number_format($energia['COFINS'], 2, ',', '.') ?></td>
                        <td><?= number_format($energia['TOTAL_horas'], 2, ',', '.') ?></td>
                        <td><?= date('d/m/Y', strtotime($energia['Ultima_Atualizacao'])) ?></td>
                        <td>
                            <a href="../controllers/editar_energia.php?id=<?= $energia['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <!-- Botão para abrir o modal de confirmação -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarExclusaoModal" data-bs-id="<?= $energia['id'] ?>">
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
                    Tem certeza que deseja excluir esta tarifa de energia?
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
        // Configura o modal para passar o ID da tarifa de energia a ser excluída
        const confirmarExclusaoModal = document.getElementById('confirmarExclusaoModal');
        confirmarExclusaoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Botão que acionou o modal
            const id = button.getAttribute('data-bs-id'); // Extrai o ID da tarifa de energia
            const btnConfirmarExclusao = document.getElementById('btnConfirmarExclusao');

            // Atualiza o link de exclusão com o ID da tarifa de energia
            btnConfirmarExclusao.href = `../controllers/excluir_energia.php?id=${id}`;
        });
    </script>
</body>
</html>