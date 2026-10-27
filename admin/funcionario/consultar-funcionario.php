<?php

// Verificando se existe um usuário logado e Administrador para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioAdmin.php";

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
                    <i class="fa-solid fa-id-card icon-section"></i>
                    <h2 class="section-title">Consultar funcionários</h2>
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

                        <!-- Filtrar por Sexo -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por sexo:</p>

                            <select name="filter-sexo" id="filter-sexo">
                                <option value="" class="form-option" selected>
                                    < Selecionar >
                                </option>
                                
                                <option value="N" class="form-option">Não Informado</option>
                                <option value="M" class="form-option">Masculino</option>
                                <option value="F" class="form-option">Feminino</option>
                            </select>
                        </label>

                        <!-- Filtrar por Cidade -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por cidade:</p>

                            <select name="filter-cidade" id="filter-cidade">
                                <option value="" class="form-option" selected>
                                    < Selecionar >
                                </option>

                                <?php 
                                
                                $sql = "SELECT DISTINCT cidade FROM funcionario WHERE status = 1 AND cidade != ''";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $res = $stmt->fetchAll();

                                if (count($res) > 0) {
                                    foreach ($res as $cidade) {
                                        if (empty($cidade)) continue;

                                        echo
                                        '
                                        <option value="'. $cidade["cidade"] .'" class="form-option">'. $cidade["cidade"] .'</option>
                                        ';
                                    }
                                }
                                
                                ?>
                            </select>
                        </label>

                        <!-- Filtrar por Cargo -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por cargo:</p>

                            <select name="filter-cargo" id="filter-cargo">
                                <option value="" class="form-option" selected>
                                    < Selecionar >
                                </option>
                                <?php

                                $sql = "SELECT id_cargo, nome FROM cargo WHERE status = 1";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();
                                $res = $stmt->fetchAll();

                                if (count($res) > 0)
                                    foreach ($res as $funcionario) {
                                        echo '<option value="' . $funcionario["id_cargo"] . '" class="form-option">' . $funcionario["nome"] . '</option>';
                                    }

                                ?>
                            </select>
                        </label>

                        <!-- Filtrar por Nome -->
                        <label class="input-label">
                            <p class="label-name">Filtrar por nome:</p>

                            <input type="text" name="filter-nome" id="filter-nome" class="form-input">
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
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Cargo</th>
                                <th>Sexo</th>
                                <th>CPF</th>
                                <th>RG</th>
                                <th>Data Nascimento</th>
                                <th>Estado Civil</th>
                                <th>Cidade</th>
                                <th>Estado</th>
                                <th>Endereço</th>
                                <th>Número</th>
                                <th>Bairro</th>
                                <th>Complemento</th>
                                <th>CEP</th>
                                <th>Telefone Residencial</th>
                                <th>Telefone Celular</th>
                                <th>Usuário</th>
                                <th>E-mail</th>
                                <th>Senha</th>
                                <th>Tipo de Acesso</th>
                                <th>Salário</th>
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

                const res = await fetch("filtrar-funcionario.php?" + queryString);

                if (res.ok) {
                    const data = await res.text();
                    dataTable.innerHTML = data;
                }
            } catch (e) {
                console.error(e);
            }

            // Filtragem | Selects
            const filterSelects = [document.getElementById("filter-status"), document.getElementById("filter-sexo"), document.getElementById("filter-cidade"), document.getElementById("filter-cargo")];
            filterSelects.forEach(elem => elem.addEventListener("change", loadTable));

            // Filtragem | Text Inputs
            const filterTexts = [document.getElementById("filter-nome")];
            filterTexts.forEach(elem => elem.addEventListener("input", loadTable));
        }
    </script>
</body>

</html>