# Projeto de Masmorra RPG

Este projeto é um gerador de masmorras para jogos de RPG. Ele permite que os usuários explorem salas geradas aleatoriamente, rolem dados e visualizem um mapa completo da masmorra.

## Funcionalidades

- **Gerador de Salas**: Cada sala é gerada aleatoriamente com descrições, monstros e tesouros únicos.
- **Rolagem de Dados**: Os usuários podem rolar diferentes tipos de dados (moeda, d4, d6, d8, d10, d12, d20, d100) e ver os resultados.
- **Mapa Completo**: Um link permite que os usuários visualizem o mapa completo da masmorra em um modal.

## Estrutura do Projeto

- `assets/`: Contém arquivos CSS, fontes, imagens e JavaScript.
  - `css/styles.css`: Estilos para o projeto.
  - `images/`: Imagens usadas no projeto.
- `includes/`: Contém arquivos PHP incluídos em várias partes do projeto.
  - `database.php`: Conexão com o banco de dados.
  - `gerar_sala.php`: Função para gerar salas.
  - `header.php`: Cabeçalho do site.
- `pages/`: Contém as páginas principais do projeto.
  - `sala.php`: Página para exibir uma sala específica.
- `templates/`: Contém templates usados em várias partes do projeto.
  - `footer.php`: Rodapé do site.
- `index.php`: Página inicial do projeto.

## Como Usar

1. Clone o repositório para o seu ambiente local.
2. Configure o banco de dados no arquivo `includes/database.php`.
3. Acesse a página inicial (`index.php`) para começar a explorar a masmorra.

## Exemplo de Uso

### Gerar uma Sala

A função `gerarSala` no arquivo `includes/gerar_sala.php` é usada para gerar uma sala com base no ID da sala e na conexão com o banco de dados.

### Rolagem de Dados

Os botões para rolar dados estão localizados na página `pages/sala.php`. Cada botão chama a função JavaScript `rolarDado(tipo)` para gerar um resultado aleatório e exibi-lo na página.

### Visualizar o Mapa Completo

O link "Ver Mapa Completo da Masmorra" abre um modal com a imagem do mapa completo (`masmorraGM.png`).

## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests para melhorar o projeto.

## Licença

Este projeto está licenciado sob a Licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.