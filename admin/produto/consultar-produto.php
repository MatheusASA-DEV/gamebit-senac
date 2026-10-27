<?php

// Verificando se existe um usuário logado para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioComum.php";

require_once __DIR__ . "/../../connection/connection.php"

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Matheus de Andrade Silva Arruda">
    <title>GameBit | Painel Administrativo</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
        integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- My Styles -->
    <link rel="stylesheet" href="../../custom/css/global.css">
    <link rel="stylesheet" href="../../custom/css/dashboard.css">
</head>

<body>
    <div id="dashboard-container">
        <?php include "../../components/DashboardSidebar.php" ?>

        <main>
            <?php require_once __DIR__ . "/../utils/message.php" ?>

            <section id="dashboard-content" class="dashboard-section">
                <div class="section-title-container">
                    <i class="fa-solid fa-box-archive icon-section"></i>
                    <h2 class="section-title">Consultar produtos</h2>
                </div>

                <!-- Seção de Filtros -->
                <form method="get" id="filter-form">
                    <div class="inputs-wrapper">
                        <!-- Filtrar por Status -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por status:</p>

                            <select name="filter-status" id="filter-status">
                                <option value="" class="form-option" selected>
                                    < Selecionar >
                                </option>

                                <option value="0" class="form-option">Inativo</option>
                                <option value="1" class="form-option">Ativo</option>
                            </select>
                        </label>

                        <!-- Filtrar por Nome -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por nome:</p>

                            <input type="text" name="filter-nome" id="filter-nome" class="form-input">
                        </label>

                        <!-- Filtrar por Desenvolvedor -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por desenvolvedor:</p>

                            <select name="filter-desenvolvedor" id="filter-desenvolvedor">
                                <option value="" class="form-option" selected>
                                    < Selecionar >
                                </option>

                                <?php 
                                
                                $sql = "SELECT id_desenvolvedor, nome FROM desenvolvedor WHERE status = 1";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $res = $stmt->fetchAll();

                                foreach ($res as $desenvolvedor) {
                                    echo
                                    '
                                    <option value="'. $desenvolvedor["id_desenvolvedor"] .'" class="form-option">'. $desenvolvedor["nome"] .'</option>
                                    ';
                                }
                                
                                ?>

                            </select>
                        </label>

                        <!-- Filtrar por Marca -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por marca:</p>

                            <select name="filter-marca" id="filter-marca">
                                <option value="" class="form-option" selected>
                                    < Selecionar >
                                </option>

                                <?php 
                                
                                $sql = "SELECT id_marca, nome FROM marca WHERE status = 1";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $res = $stmt->fetchAll();

                                foreach ($res as $marca) {
                                    echo
                                    '
                                    <option value="'. $marca["id_marca"] .'" class="form-option">'. $marca["nome"] .'</option>
                                    ';
                                }
                                
                                ?>

                            </select>
                        </label>


                        <!-- Filtrar por Estoque Mín e Máx -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por estoque:</p>

                            <input type="text" name="filter-estoque-min" id="filter-estoque-min" class="form-input" placeholder="Mín">
                        </label>

                        <label class="input-label">
                            <p class="label-name">Filtrar por estoque:</p>

                            <input type="text" name="filter-estoque-max" id="filter-estoque-max" class="form-input" placeholder="Máx">
                        </label>


                        <!-- Filtrar por Categoria -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por categoria:</p>

                            <select name="filter-categoria" id="filter-categoria">
                                <option value="" class="form-option" selected>
                                    < Selecionar >
                                </option>

                                <?php 
                                
                                $sql = "SELECT id_categoria, nome FROM categoria WHERE status = 1";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $res = $stmt->fetchAll();

                                foreach ($res as $categoria) {
                                    echo
                                    '
                                    <option value="'. $categoria["id_categoria"] .'" class="form-option">'. $categoria["nome"] .'</option>
                                    ';
                                }
                                
                                ?>

                            </select>
                        </label>
                    </div>
                </form>

                <!-- Tabela de registros -->
                <div id="table-container">
                    <!-- Tabela em sí -->
                    <table>
                        <!-- Cabeçalho da Tabela -->
                        <thead>
                            <!-- Linha de Tabela -->
                            <tr>
                                <!-- Header da Tabela -->
                                <th>ID</th>
                                <th>Imagem</th>
                                <th>Categoria</th>
                                <th>Nome</th>
                                <th>Estoque</th>
                                <th>Custo</th>
                                <th>Lucro (%)</th>
                                <th>Preço</th>
                                <th>Promoção Ativa</th>
                                <th>Desconto (%)</th>
                                <th>Preço na Promoção</th>
                                <th>Descrição</th>
                                <th>Marca</th>
                                <th>Plataforma</th>
                                <th>Genêro</th>
                                <th>Desenvolvedor</th>
                                <th>CPU</th>
                                <th>GPU</th>
                                <th>RAM</th>
                                <th>SO</th>
                                <th>Armazenamento</th>
                                <th>Leitor</th>
                                <th>Voltagem</th>
                                <th>Data de Cadastro</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <!-- Corpo da Tabela -->
                        <tbody id="data-table"></tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Script Dashboard -->
    <script src="../../custom/js/dashboard.js"></script>
    <script src="../../custom/js/message-box.js"></script>

    <!-- Script AJAX (Asynchronous JavaScript and XML) -->
    <script>
        document.addEventListener("DOMContentLoaded", loadTable);

        async function loadTable() {
            // Tabela de dados
            const dataTable = document.getElementById("data-table");

            // Lendo o formulário e transform em um objeto de uma só vez (FormData)
            const filterForm = document.getElementById("filter-form");
            const filterFormData = new FormData(filterForm);
            const queryString = new URLSearchParams(filterFormData).toString();

            try {
                dataTable.innerHTML = '<td class="table-info">Buscando...</td>'

                const res = await fetch("filtrar-produto.php?" + queryString);

                if (res.ok) {
                    const data = await res.text();
                    dataTable.innerHTML = data;
                }
            } catch (e) {
                console.error(e);
            }

            // Filtragem | Selects
            const filterSelects = [document.getElementById("filter-status"), document.getElementById("filter-desenvolvedor"), document.getElementById("filter-marca"), document.getElementById("filter-categoria")];
            filterSelects.forEach(elem => elem.addEventListener("change", loadTable));

            // Filtragem | Text Inputs
            const filterTexts = [document.getElementById("filter-nome")];
            filterTexts.forEach(elem => elem.addEventListener("input", loadTable));

            const estoqueMin = document.getElementById("filter-estoque-min");
            const estoqueMax = document.getElementById("filter-estoque-max");

            const estoqueFields = [estoqueMin, estoqueMax];
            estoqueFields.forEach(input => input.addEventListener("input", () => {
                if (estoqueMin.value != "" && estoqueMax.value != "") { loadTable() };
            }))
        }
    </script>
</body>

</html>