<?php
session_start();
include 'includes/header.php';
?>

<div class="container-centralizado">
    <h1>Bem-vindo, Aventureiro!</h1>

    <p>Você recebeu um cartão de visita incomum das mãos de um misterioso mago. A frente do cartão parece comum, com o nome da <strong>Loja do Mago</strong>, seu logo intrigante e algumas informações de contato. No entanto, ao virar o cartão, você se depara com algo extraordinário: um mapa detalhado de uma masmorra e um <a href='https://rpgzinho.com.br' class="footer-link">URL</a> intrigante.</p>

    <p>Este não é um cartão de visita comum. O mago, conhecido por suas habilidades enigmáticas, transformou o verso do cartão em um portal para uma aventura única. O mapa que você vê acima é a chave para explorar uma masmorra cheia de perigos, tesouros e mistérios.</p>

    <h2>O Que Você Encontrará Aqui</h2>
    <p>Este site contém o mapa da masmorra (há uma versão em página inteira que você pode imprimir, peça ao <a href='https://www.instagram.com/mestreparacelso/' class="footer-link">mago</a>) e tabelas especiais que foram cuidadosamente ajustadas para serem usadas com dados e pela imaginação humana. Com essas ferramentas, você pode criar uma masmorra única toda vez que explorar.</p>

    <p>Os monstros e tesouros que você encontrará não estão vinculados a nenhum sistema de jogo específico. Como aventureiro, você sabe como um orc, um esqueleto ou um dragão deve se comportar no seu mundo. Da mesma forma, os tesouros são descritos em "peças de ouro", mas podem ser facilmente adaptados para moedas de prata, créditos ou qualquer outra forma de riqueza que faça sentido na sua jornada. Defina as regras conforme necessário. Esta é uma masmorra genérica, projetada para ser útil para o maior número de aventureiros possível.</p>

    <h2>Como Funciona</h2>
    <p>A masmorra é totalmente automatizada e gerada proceduralmente. Toda vez que você entrar em uma sala, ela será criada aleatoriamente, com novas descrições, monstros e tesouros. Isso significa que cada visita a uma sala será única, e você nunca saberá o que esperar.</p>

    <p>Se você quiser explorar uma versão diferente da sala atual, basta usar o botão <strong>"Regenerar Sala"</strong>. Isso criará uma nova versão da sala, com novos desafios e recompensas.</p>

    <p>Uma opção divertida é que, se o grupo voltar a uma sala que já explorou antes, ela pode estar completamente diferente. Novas descrições, novos monstros, novos tesouros... Isso fará com que eles questionem suas habilidades de mapeamento e, possivelmente, até sua sanidade!</p>

    <h3>Leve a Aventura com Você</h3>
    <p>Este cartão é a chave para uma aventura que você pode levar no bolso. Graças à magia do mago, você pode explorar a masmorra a qualquer momento, em qualquer lugar. Basta acessar o site e começar sua jornada. Nunca se sabe quando você precisará enfrentar um desafio ou descobrir um tesouro escondido!</p>

    <h3>Notas do Mapa</h3>
    <div class="notas-mapa">
        <p><strong>“C”</strong>: Indica uma porta oculta.</p>
        <p><strong>“S”</strong>: Indica uma porta secreta.</p>
        <p><strong><img src="/assets/images/trap.png" alt="Armadilha" style="width: 20px; height: 20px; border: 1px solid #000; border-radius: 3px;"></strong>: Indica uma armadilha.</p>
    </div>

    <h2>Prepare-se para a Aventura</h2>
    <p>Clique no botão abaixo para começar sua jornada e explorar a masmorra que o mago preparou para você. Boa sorte, aventureiro!</p>

    <a href="pages/sala.php?sala=1" class="btn">Começar a Aventura</a>
</div>

<?php
include 'templates/footer.php';
?>