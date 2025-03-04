<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestão 3D</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="estilo.css"> <!-- Seu arquivo CSS -->
</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="../views/index.php">Gestão 3D</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../views/index.php">Início</a></li>
                <li class="nav-item"><a class="nav-link" href="../views/produtos.php">Produtos</a></li>
                <li class="nav-item"><a class="nav-link" href="../views/estudios.php">Estúdios</a></li>

                <!-- Dropdown Suprimentos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarSuprimentos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Suprimentos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarSuprimentos">
                        <li><a class="dropdown-item" href="../views/pecas.php">Peças 3D</a></li>
                        <li><a class="dropdown-item" href="../views/componentes.php">Componentes</a></li>
                    </ul>
                </li>
                
                <!-- Dropdown Consumíveis -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarConsumiveis" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Consumíveis
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarConsumiveis">
                        <li><a class="dropdown-item" href="../views/filamentos.php">Filamentos</a></li>
                        <li><a class="dropdown-item" href="../views/resinas.php">Resinas</a></li>
                        <li><a class="dropdown-item" href="../views/lavagem.php">Lavagem</a></li>
                    </ul>
                </li>

                <!-- Dropdown Equipamentos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarEquipamentos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Equipamentos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarEquipamentos">
                        <li><a class="dropdown-item" href="../views/impressoras.php">Impressoras</a></li>
                        <li><a class="dropdown-item" href="../views/estacoes_lavagem.php">Estações de Lavagem</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link" href="../views/energia.php">Energia</a></li>
            </ul>
            
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['usuario_nome'])): ?>
                    <li class="nav-item">
                        <span class="navbar-text text-white">Bem-vindo, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger btn-sm ms-3" href="logout.php">Sair</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>