<?php 

// USAR GET PARA PEGAR VALOR DE CATEGORIA AO ACESSAR product-grid.php PARA DETERMINAR A CLASSE "selected" NOS LINKS
// REMOVER ISSO
// Verifica qual página estamos
$currentPage = basename($_SERVER["PHP_SELF"]);
require_once __DIR__ . "/../config/config.php";

?>

<header>
    <div class="container">
        <div id="header-content">
            <!-- Header Logo -->
            <a href="<?= $finalURL ?>/index.php" class="logo">
                <i class="fa-solid fa-gamepad icon-logo"></i>
                <span class="logo-name">GameBit</span>
            </a>

            <!-- Pesquisar -->
            <form action="<?= $finalURL ?>/admin/Search.php" method="get" id="search-form" class="">
                <input type="search" name="q" id="search-input" placeholder="Encontre aqui o que procura..." autocomplete="off">
                <button type="submit" id="search-button"><i class="fa-solid fa-magnifying-glass icon-menu"></i></button>
            </form>

            <!-- Navegação -->
            <nav id="nav-header" class="">
                <ul id="nav-list">
                    <li class="nav-item">
                        <a href="<?= $finalURL ?>/pages/product-grid.php" class="nav-link <?= $currentPage == "product-grid.php" ? "active" : "" ?>">Produtos</a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link <?= $currentPage == "about.php" ? "active" : "" ?>">Sobre</a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">Promoções</a>
                    </li>
                </ul>
            </nav>

            <div id="mob-buttons-wrapper">
                <button type="button" id="mob-open-search" class="h-btn"><i
                        class="fa-solid fa-magnifying-glass icon-menu"></i></button>

                <a href="<?= $finalURL ?>/admin" class="h-btn login-link"><i class="fa-regular fa-user icon-menu"></i></a>

                <!-- Abrir/Fechar Menu de Navegação em Dispositivos Móveis -->
                <button type="button" id="mob-open-nav"><i class="fa-solid fa-bars icon-menu"></i></button>
            </div>
        </div>
    </div>
</header>