<?php 

require_once __DIR__ . "/../connection/connection.php";
require_once __DIR__ . "/../config/config.php";

// Buscar a foto do funcionário
$sql = "SELECT foto FROM funcionario WHERE id_func = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([":id" => $_SESSION["ID"]]);
$foto = $stmt->fetchColumn();

?>

<div class="account-settings">
    <a href="<?= $finalURL ?>/admin/Logoff.php" class="account-setting">
        <i class="fa-solid fa-arrow-right-from-bracket acc-icon"></i>
        Sair
    </a>
</div>

<aside id="dashboard-sidebar">
    <button type="button" id="admin-user">
        <div id="admin-photo-container">
            <img src="<?= $finalURL ?>/images/funcionarios/<?= $foto ?>" alt="Imagem do funcionário">
        </div>

        <span id="admin-username"><?= $_SESSION["NAME"] ?? null ?></span>
    </button>

    <nav id="sidebar-navigation">
        <a href="<?= $finalURL ?>/admin/dashboard/dashboard.php" class="navigation-accordion sidebar-navigation-button">
            <i class="fa-solid fa-chart-simple icon-sidebar"></i>
            Visão Geral
        </a>

        <!-- Consultar -->
        <div class="sidebar-navigation-group">
            <button type="button" class="navigation-accordion sidebar-navigation-button">
                <i class="fa-solid fa-database icon-sidebar"></i>
                Consultar
            </button>

            <div class="navigation-options">
                <div class="options-body">
                    <a href="<?= $finalURL ?>/admin/cliente/consultar-cliente.php" class="navigation-link sidebar-navigation-button">
                        Clientes
                    </a>
                    
                    <a href="<?= $finalURL ?>/admin/funcionario/consultar-funcionario.php" class="navigation-link sidebar-navigation-button" <?= ($_SESSION["TYPE"] ?? null) == "0" ? "hidden" : "" ?> >
                        Funcionários
                    </a>

                    <a href="<?= $finalURL ?>/admin/produto/consultar-produto.php" class="navigation-link sidebar-navigation-button">
                        Produtos
                    </a>

                    <a href="<?= $finalURL ?>/admin/cargo/consultar-cargo.php" class="navigation-link sidebar-navigation-button">
                        Cargos
                    </a>

                    <a href="<?= $finalURL ?>/admin/marca/consultar-marca.php" class="navigation-link sidebar-navigation-button">
                        Marcas
                    </a>

                    <a href="<?= $finalURL ?>/admin/plataforma/consultar-plataforma.php" class="navigation-link sidebar-navigation-button">
                        Plataformas
                    </a>

                    <a href="<?= $finalURL ?>/admin/desenvolvedor/consultar-desenvolvedor.php" class="navigation-link sidebar-navigation-button">
                        Desenvolvedores
                    </a>

                    <a href="<?= $finalURL ?>/admin/genero_jogo/consultar-genero.php" class="navigation-link sidebar-navigation-button">
                        Genêros de Jogos
                    </a>

                    <a href="<?= $finalURL ?>/admin/categoria/consultar-categoria.php" class="navigation-link sidebar-navigation-button">
                        Categorias
                    </a>
                </div>
            </div>
        </div>

        <!-- Cadastrar -->
        <div class="sidebar-navigation-group">
            <button type="button" class="navigation-accordion sidebar-navigation-button">
                <i class="fa-solid fa-square-plus icon-sidebar"></i>
                Cadastrar
            </button>

            <div class="navigation-options">
                <div class="options-body">
                    <a href="<?= $finalURL ?>/admin/cliente/cadastrar-cliente.php" class="navigation-link sidebar-navigation-button">
                        Clientes
                    </a>

                    <a href="<?= $finalURL ?>/admin/funcionario/cadastrar-funcionario.php" class="navigation-link sidebar-navigation-button" <?= ($_SESSION["TYPE"] ?? null) == "0" ? "style='display: none;'" : "" ?> >
                        Funcionários
                    </a>

                    <a href="<?= $finalURL ?>/admin/produto/cadastrar-produto.php" class="navigation-link sidebar-navigation-button">
                        Produtos
                    </a>

                    <a href="<?= $finalURL ?>/admin/cargo/cadastrar-cargo.php" class="navigation-link sidebar-navigation-button">
                        Cargos
                    </a>

                    <a href="<?= $finalURL ?>/admin/marca/cadastrar-marca.php" class="navigation-link sidebar-navigation-button">
                        Marcas
                    </a>

                    <a href="<?= $finalURL ?>/admin/plataforma/cadastrar-plataforma.php" class="navigation-link sidebar-navigation-button">
                        Plataformas
                    </a>

                    <a href="<?= $finalURL ?>/admin/desenvolvedor/cadastrar-desenvolvedor.php" class="navigation-link sidebar-navigation-button">
                        Desenvolvedores
                    </a>

                    <a href="<?= $finalURL ?>/admin/genero_jogo/cadastrar-genero.php" class="navigation-link sidebar-navigation-button">
                        Genêros de Jogos
                    </a>

                    <a href="<?= $finalURL ?>/admin/categoria/cadastrar-categoria.php" class="navigation-link sidebar-navigation-button">
                        Categorias
                    </a>
                </div>
            </div>
        </div>

        <!-- Botão de sair -->
        <a href="<?= $finalURL ?>/index.php" id="exit-dashboard" class="sidebar-navigation-button">
            <i class="fa-solid fa-circle-arrow-left icon-sidebar"></i>
            Ir para o site
        </a>
    </nav>
</aside>