📂 Estrutura de Pastas Recomendada

gestao3d/
│── 📂 assets/          # Arquivos estáticos (CSS, JS, imagens, fontes)
│   ├── css/           # Arquivos CSS
│   │   ├── estilo.css
│   ├── js/            # Scripts JavaScript
│   ├── img/           # Imagens do sistema
│
│── 📂 config/          # Configuração do sistema
│   ├── config.php      # Conexão com o banco de dados
│   ├── auth.php        # Verificação de login/autenticação
│
│── 📂 controllers/     # Lógica de processamento (CRUDs)
│   ├── adicionar_peca.php
│   ├── editar_peca.php
│   ├── excluir_peca.php
│   ├── listar_pecas.php
│   ├── adicionar_estudio.php
│   ├── editar_estudio.php
│   ├── excluir_estudio.php
│   ├── ...
│
│── 📂 views/           # Páginas visíveis ao usuário
│   ├── index.php       # Página inicial
│   ├── login.php       # Tela de login
│   ├── logout.php      # Tela de logout
│   ├── pecas.php       # Listagem de peças
│   ├── estudios.php    # Listagem de estúdios
│   ├── impressoras.php # Listagem de impressoras
│   ├── ...
│
│── 📂 includes/        # Componentes reutilizáveis
│   ├── header.php      # Cabeçalho do site
│   ├── footer.php      # Rodapé do site
│   ├── menu.php        # Menu de navegação
│
│── 📂 database/        # Scripts SQL e backups
│   ├── backup.sql      # Backup do banco de dados
│   ├── tabelas.sql     # Estrutura do banco de dados
│
│── 📂 uploads/         # Uploads de arquivos (STL, imagens, etc.)
│   ├── pecas/          # Arquivos STL das peças
│   ├── imagens/        # Imagens de peças e impressoras
│
│── .htaccess           # Arquivo de configuração do Apache
│── README.md           # Informações sobre o projeto


📌 Explicação das Pastas
assets/ → Para armazenar arquivos CSS, JavaScript, imagens, fontes.
config/ → Contém arquivos de configuração, como a conexão com o banco (config.php).
controllers/ → Toda a lógica do sistema (CRUDs, processamentos de formulários).
views/ → Páginas que o usuário acessa diretamente (listas, formulários).
includes/ → Componentes reutilizáveis como menu.php, header.php e footer.php.
database/ → Scripts SQL do banco de dados (backups e estrutura).
uploads/ → Diretório para armazenar arquivos enviados pelos usuários.