$(document).ready(function() {
    // Carregar atributos ao selecionar uma categoria
    $('#categoria').change(function() {
        let categoria_id = $(this).val();
        if (categoria_id) {
            $.ajax({
                url: '../controllers/buscar_atributos.php',
                type: 'GET',
                data: { categoria_id: categoria_id },
                success: function(response) {
                    $('#atributos-container').html(response);
                }
            });
        } else {
            $('#atributos-container').html('');
        }
    });

    // Autocomplete para Peças
    $("#buscarPeca").autocomplete({
        source: "../controllers/buscar_pecas.php",
        minLength: 2,
        select: function(event, ui) {
            let pecaId = ui.item.id;
            let pecaNome = ui.item.value;
            let pecaImagem = ui.item.imagem;

            if ($("#peca_" + pecaId).length === 0) {
                $("#tabelaPecas").append(`
                    <tr id="peca_${pecaId}">
                        <td>
                            ${pecaImagem ? `<img src="${pecaImagem}" alt="Imagem da peça" class="img-thumbnail" style="max-width: 50px;">` : 'Sem imagem'}
                        </td>
                        <td>${pecaNome}</td>
                        <td><input type="number" name="pecas[${pecaId}]" value="1" min="1" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger removerPeca" data-id="${pecaId}">Remover</button></td>
                    </tr>
                `);
            }
            $("#buscarPeca").val('');
            return false;
        }
    });

    // Autocomplete para Componentes
    $("#buscarComponente").autocomplete({
        source: "../controllers/buscar_componentes.php",
        minLength: 2,
        select: function(event, ui) {
            let componenteId = ui.item.id;
            let componenteNome = ui.item.value;
            let componenteImagem = ui.item.imagem;

            if ($("#componente_" + componenteId).length === 0) {
                $("#tabelaComponentes").append(`
                    <tr id="componente_${componenteId}">
                        <td>
                            ${componenteImagem ? `<img src="${componenteImagem}" alt="Imagem do componente" class="img-thumbnail" style="max-width: 50px;">` : 'Sem imagem'}
                        </td>
                        <td>${componenteNome}</td>
                        <td><input type="number" name="componentes[${componenteId}]" value="1" min="1" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger removerComponente" data-id="${componenteId}">Remover</button></td>
                    </tr>
                `);
            }
            $("#buscarComponente").val('');
            return false;
        }
    });

    // Remover peça da tabela
    $(document).on("click", ".removerPeca", function() {
        let pecaId = $(this).data("id");
        $("#peca_" + pecaId).remove();
    });

    // Remover componente da tabela
    $(document).on("click", ".removerComponente", function() {
        let componenteId = $(this).data("id");
        $("#componente_" + componenteId).remove();
    });

    // Autocomplete para Tags
    $("#buscarTag").autocomplete({
        source: "../controllers/buscar_tags.php",
        minLength: 2,
        select: function(event, ui) {
            let tagNome = ui.item.value;

            // Verifica se a tag já foi adicionada
            if ($("#tag_" + tagNome).length === 0) {
                $("#tagsSelecionadas").append(`
                    <span id="tag_${tagNome}" class="badge bg-primary me-2">
                        ${tagNome}
                        <input type="hidden" name="tags[]" value="${tagNome}">
                        <button type="button" class="btn-close btn-close-white ms-2 removerTag" data-nome="${tagNome}"></button>
                    </span>
                `);
            }
            $("#buscarTag").val('');
            return false;
        }
    });

    // Adicionar tag ao pressionar Enter
    $("#buscarTag").on("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Impede o envio do formulário

            let tagNome = $(this).val().trim(); // Pega o valor do campo

            if (tagNome) {
                // Verifica se a tag já foi adicionada
                if ($("#tag_" + tagNome).length === 0) {
                    $("#tagsSelecionadas").append(`
                        <span id="tag_${tagNome}" class="badge bg-primary me-2">
                            ${tagNome}
                            <input type="hidden" name="tags[]" value="${tagNome}">
                            <button type="button" class="btn-close btn-close-white ms-2 removerTag" data-nome="${tagNome}"></button>
                        </span>
                    `);
                }
                $(this).val(''); // Limpa o campo
            }
        }
    });

    // Remover tag
    $(document).on("click", ".removerTag", function() {
        let tagNome = $(this).data("nome");
        $("#tag_" + tagNome).remove();
    });

    // Remover imagem adicional
    $(document).on("click", ".removerImagem", function() {
        let imagemId = $(this).data("id");
        $(this).closest('.position-relative').remove();
        $('<input>').attr({
            type: 'hidden',
            name: 'imagens_excluir[]',
            value: imagemId
        }).appendTo('form');
    });

    // Pré-visualização da imagem do produto
    document.getElementById('imagemProduto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('previewImagemProduto');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Pré-visualização das imagens adicionais
    document.getElementById('imagensAdicionais').addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('previewImagensAdicionais');
        previewContainer.innerHTML = ''; // Limpa as pré-visualizações anteriores

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.classList.add('position-relative', 'me-2', 'mb-2');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.maxWidth = '100px';
                    img.style.maxHeight = '100px';

                    const btnExcluir = document.createElement('button');
                    btnExcluir.innerHTML = '&times;';
                    btnExcluir.classList.add('btn-close', 'position-absolute', 'top-0', 'end-0');
                    btnExcluir.style.backgroundColor = 'red';
                    btnExcluir.style.padding = '5px';
                    btnExcluir.style.borderRadius = '50%';
                    btnExcluir.style.cursor = 'pointer';
                    btnExcluir.dataset.index = i; // Armazena o índice da imagem

                    // Adiciona evento de clique para remover a imagem
                    btnExcluir.addEventListener('click', function() {
                        imgContainer.remove(); // Remove a miniatura
                        removeImagemDoInput(btnExcluir.dataset.index); // Remove a imagem do input
                    });

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(btnExcluir);
                    previewContainer.appendChild(imgContainer);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    // Função para remover a imagem do input de arquivo
    function removeImagemDoInput(index) {
        const input = document.getElementById('imagensAdicionais');
        const files = Array.from(input.files);

        // Remove a imagem do array
        files.splice(index, 1);

        // Cria um novo FileList com os arquivos restantes
        const newFileList = new DataTransfer();
        files.forEach(file => newFileList.items.add(file));

        // Atualiza o input de arquivo com as imagens restantes
        input.files = newFileList.files;

        // Reindexa as miniaturas restantes
        reindexarMiniaturas();
    }

    // Função para reindexar as miniaturas restantes
    function reindexarMiniaturas() {
        const previewContainer = document.getElementById('previewImagensAdicionais');
        const miniaturas = previewContainer.querySelectorAll('.position-relative');

        miniaturas.forEach((miniatura, index) => {
            const btnExcluir = miniatura.querySelector('.btn-close');
            btnExcluir.dataset.index = index; // Atualiza o índice do botão de exclusão
        });
    }
});