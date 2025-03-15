<?php
function gerarSala($sala_id) {
    $sala = [
        'descricao' => "Esta é a sala $sala_id. Prepare-se para o que está por vir!",
        'imagem' => "sala$sala_id.jpg" // Supondo que as imagens sejam nomeadas como sala1.jpg, sala2.jpg, etc.
    ];

    switch ($sala_id) {
        case 1:
            $sala['paredes'] = gerarParedes();
            $sala['chao'] = gerarChao();
            $sala['monstro'] = gerarMonstro();
            $sala['sons_fracos'] = gerarSonsFracos();
            break;
        case 2:
            $sala['paredes'] = gerarParedes();
            $sala['portas'] = gerarPortas();
            $sala['monstro'] = gerarMonstro();
            $sala['decoracao'] = gerarDecoracao();
            break;
        case 3:
            $sala['circulo'] = gerarCirculo();
            $sala['magia'] = gerarMagia();
            $sala['agua'] = gerarAgua();
            $sala['monstro'] = gerarMonstro();
            break;
        case 4:
            $sala['monstro'] = gerarMonstro();
            $sala['tesouro'] = gerarTesouro();
            break;
        case 5:
            $sala['paredes'] = gerarParedes();
            $sala['lado'] = gerarLado();
            $sala['chao'] = gerarChao();
            $sala['luz'] = gerarLuz();
            break;
        case 6:
            $sala['cobertura_porta'] = gerarCoberturaPorta();
            $sala['monstro'] = gerarMonstro();
            break;
        case 7:
            $sala['chao'] = gerarChao();
            $sala['estatuas'] = gerarEstatuas();
            $sala['assunto_estatua'] = gerarAssuntoEstatua();
            $sala['monstro'] = gerarMonstro();
            $sala['tesouro'] = gerarTesouro();
            break;
        case 8:
            $sala['armadilha'] = gerarArmadilha();
            $sala['conteudo_buraco'] = gerarConteudoBuraco();
            $sala['tipo_spray'] = gerarTipoSpray();
            $sala['numero_pessoa'] = gerarNumeroPessoa();
            break;
    }

    return $sala;
}


function gerarParedes() {
    $opcoes = ["Paredes de pedra áspera", "Paredes com vestígios de antigos murais", "Paredes de pedra com argamassa"];
    return $opcoes[array_rand($opcoes)];
}

function gerarChao() {
    $opcoes = ["Folhas mortas e detritos", "Nada de notável", "Ossos roídos e manchas de sangue", "Restos de uma estátua esmagada"];
    return $opcoes[array_rand($opcoes)];
}

function gerarMonstro() {
    $opcoes = ["Estátuas vivas", "Goblins", "Centopeias grandes", "Sons à distância"];
    return $opcoes[array_rand($opcoes)];
}

function gerarSonsFracos() {
    $opcoes = ["Assobio", "Gemidos", "Rosnados", "Arranhões"];
    return $opcoes[array_rand($opcoes)];
}

function gerarPortas() {
    $opcoes = ["Portas de madeira", "Portas de madeira reforçadas com ferro", "Portas de ferro"];
    return $opcoes[array_rand($opcoes)];
}

function gerarDecoracao() {
    $opcoes = ["Tocha queimada", "Teias de aranha", "Mancha de ico", "Pedaço de lâmina quebrada", "Cheiro de mofo", "Água pingando"];
    return $opcoes[array_rand($opcoes)];
}

function gerarCirculo() {
    $opcoes = ["Círculo mágico", "Poça de água", "Anel de cogumelos", "Poça de água estagnada"];
    return $opcoes[array_rand($opcoes)];
}

function gerarMagia() {
    $opcoes = ["Figuras encapuzadas", "Demônio menor", "Pilha de ossos"];
    return $opcoes[array_rand($opcoes)];
}

function gerarAgua() {
    $opcoes = ["Veneno mortal", "Água curativa", "Elemental da água", "Piranhas"];
    return $opcoes[array_rand($opcoes)];
}

function gerarTesouro() {
    $opcoes = ["Baú de moedas", "Mapa secreto", "Chave esquelética", "Pergaminhos mágicos"];
    return $opcoes[array_rand($opcoes)];
}

function gerarLado() {
    $opcoes = ["Norte", "Leste", "Sul", "Oeste"];
    return $opcoes[array_rand($opcoes)];
}

function gerarLuz() {
    $opcoes = ["Entidade elétrica", "Vaga-lume gigante", "Luz de cadáver", "Globo de luz mágica"];
    return $opcoes[array_rand($opcoes)];
}

function gerarCoberturaPorta() {
    $opcoes = ["Pilha de lixo", "Tapeçaria mofada", "Plataforma de madeira", "Estátua de gesso", "Teias de aranha", "Ilusão de parede"];
    return $opcoes[array_rand($opcoes)];
}

function gerarEstatuas() {
    $opcoes = ["Estatuas vivas", "Armaduras animadas", "Esqueletos antigos"];
    return $opcoes[array_rand($opcoes)];
}

function gerarAssuntoEstatua() {
    $opcoes = ["Reis antigos", "Deuses com cabeças de animais", "Demônios com chifres e presas"];
    return $opcoes[array_rand($opcoes)];
}

function gerarArmadilha() {
    $opcoes = ["Armadilha de buraco", "Armadilha de urso", "Pedra sensível à pressão"];
    return $opcoes[array_rand($opcoes)];
}

function gerarConteudoBuraco() {
    $opcoes = ["Água lamacenta", "Espinhos", "Espinhos envenenados", "Escorpiões", "Piranhas", "Texugo gigante"];
    return $opcoes[array_rand($opcoes)];
}

function gerarTipoSpray() {
    $opcoes = ["Veneno", "Poção de encolhimento", "Ácido", "Líquido de coceira", "Líquido de fogo", "Líquido nauseante"];
    return $opcoes[array_rand($opcoes)];
}

function gerarNumeroPessoa() {
    $opcoes = ["Primeira pessoa", "Segunda pessoa", "Terceira pessoa"];
    return $opcoes[array_rand($opcoes)];
}
?>