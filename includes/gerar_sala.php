<?php
function gerarSala($sala_id, $pdo) {
    $elementos = [];

    // Buscar informações da sala
    $stmt = $pdo->prepare("SELECT * FROM salas WHERE id = :sala_id");
    $stmt->execute(['sala_id' => $sala_id]);
    $sala = $stmt->fetch();

    if (!$sala) {
        return [
            'descricao' => 'Sala não encontrada.',
            'imagem' => 'default.jpg',
            'elementos' => []
        ];
    }

    // Gerar elementos da sala com base no ID
    switch ($sala_id) {
        case 1:
            $elementos['Paredes'] = buscarElementoAleatorio($pdo, 'paredes');
            $elementos['Chão'] = buscarElementoAleatorio($pdo, 'chao');
            $elementos['Monstro'] = buscarElementoAleatorio($pdo, 'monstros');
            $elementos['Sons Fracos'] = buscarElementoAleatorio($pdo, 'sons_fracos');
            break;
        case 2:
            $elementos['Paredes'] = buscarElementoAleatorio($pdo, 'paredes');
            $elementos['Portas'] = buscarElementoAleatorio($pdo, 'portas');
            $elementos['Monstro'] = buscarElementoAleatorio($pdo, 'monstros');
            $elementos['Decoração da Masmorra'] = buscarElementoAleatorio($pdo, 'decoracao_masmorra');
            break;
        case 3:
            $elementos['Círculo'] = buscarElementoAleatorio($pdo, 'circulos');
            $elementos['Magia'] = buscarElementoAleatorio($pdo, 'magia');
            $elementos['Água'] = buscarElementoAleatorio($pdo, 'agua');
            $elementos['Monstro'] = buscarElementoAleatorio($pdo, 'monstros');
            break;
        case 4:
            $elementos['Monstro'] = buscarElementoAleatorio($pdo, 'monstros');
            $elementos['Tesouro'] = buscarElementoAleatorio($pdo, 'tesouros');
            break;
        case 5:
            $elementos['Paredes'] = buscarElementoAleatorio($pdo, 'paredes');
            $elementos['Lado'] = buscarElementoAleatorio($pdo, 'lado');
            $elementos['Chão'] = buscarElementoAleatorio($pdo, 'chao');
            $elementos['Luz'] = buscarElementoAleatorio($pdo, 'luz');
            break;
        case 6:
            $elementos['Cobertura da Porta'] = buscarElementoAleatorio($pdo, 'cobertura_porta');
            $elementos['Monstro'] = buscarElementoAleatorio($pdo, 'monstros');
            break;
        case 7:
            $elementos['Chão'] = buscarElementoAleatorio($pdo, 'chao');
            $elementos['Estátuas'] = buscarElementoAleatorio($pdo, 'estatuas');
            $elementos['Assunto da Estátua'] = buscarElementoAleatorio($pdo, 'assunto_estatua');
            $elementos['Monstro'] = buscarElementoAleatorio($pdo, 'monstros');
            $elementos['Tesouro'] = buscarElementoAleatorio($pdo, 'tesouros');
            break;
        case 8:
            $elementos['Armadilha'] = buscarElementoAleatorio($pdo, 'armadilhas');
            $elementos['Conteúdo do Buraco'] = buscarElementoAleatorio($pdo, 'conteudo_buraco');
            $elementos['Tipo de Spray'] = buscarElementoAleatorio($pdo, 'tipo_spray');
            $elementos['Número da Pessoa'] = buscarElementoAleatorio($pdo, 'numero_pessoa');
            break;
        default:
            $elementos['Erro'] = 'Sala inválida.';
            break;
    }

    // Construir a descrição da sala
    $descricao = "<h2>{$sala['descricao']}</h2>";

    return [
        'descricao' => $descricao,
        'imagem' => $sala['imagem'],
        'elementos' => $elementos
    ];
}

function buscarElementoAleatorio($pdo, $tabela) {
    try {
        // Verifica se a tabela existe
        $stmt = $pdo->query("SELECT 1 FROM $tabela LIMIT 1");
    } catch (PDOException $e) {
        // Se a tabela não existir, retorne uma mensagem de erro
        return "Erro: Tabela '$tabela' não encontrada.";
    }

    // Busca um elemento aleatório da tabela
    $stmt = $pdo->query("SELECT descricao FROM $tabela ORDER BY RAND() LIMIT 1");
    $resultado = $stmt->fetch();
    return $resultado ? $resultado['descricao'] : 'Nenhum elemento encontrado.';
}
?>