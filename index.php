<?php

require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/connection/connection.php";
require_once __DIR__ . "/admin/produto/RepositorioProduto.php";

$repos = new RepositorioProduto($pdo);

$produtos = $repos->ConsultarTudo(15);
$jogos = $repos->ConsultarJogos(15);
$consoles = $repos->ConsultarConsoles(15);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Matheus de Andrade Silva Arruda">
    <title>GameBit | Início</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- SwiperJS Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

    <!-- My Styles -->
    <link rel="stylesheet" href="custom/css/global.css">
    <link rel="stylesheet" href="custom/css/home.css">
</head>

<body>
    <?php include_once "components/Header.php" ?>

    <main>
        <!-- Seção de Banner -->
        <section id="hero-banner">
            <div id="hero-banner-content">
                <div id="banner-caroussel" class="swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <a href="#" class="banner-slide">
                                <picture>
                                    <source media="(min-width: 768px)" srcset="./assets/images/promo-01.jpg">
                                    <img src="./assets/images/promo-01.jpg" alt="Imagem Hero Banner" loading="eager">
                                </picture>
                            </a>
                        </div>

                        <div class="swiper-slide">
                            <a href="#" class="banner-slide">
                                <picture>
                                    <source media="(min-width: 768px)" srcset="./assets/images/promo-02.jpg">
                                    <img src="./assets/images/promo-02.jpg" alt="Imagem Hero Banner" loading="eager">
                                </picture>
                            </a>
                        </div>
                    </div>

                    <!-- Paginação SwiperJS -->
                    <div id="banner-pagination" class="swiper-pagination"></div>

                    <!-- Botões de Paginação -->
                    <div id="b-pagination-prev" class="swiper-button-prev pag-button"></div>
                    <div id="b-pagination-next" class="swiper-button-next pag-button"></div>
                </div>
            </div>
        </section>

        <!-- Seção de Jogos -->
        <section id="products-games" class="section-space">
            <div class="container">
                <div id="games-content">
                    <div class="section-title-container">
                        <i class="fa-solid fa-percent icon-section"></i>
                        <h2 class="section-title">Jogos com Desconto</h2>
                    </div>

                    <div class="swiper products-swiper">
                        <div class="swiper-wrapper">
                            <?php

                            foreach ($jogos as $jogo):

                            ?>
                                <!-- Produto inteiro -->
                                <div class="swiper-slide product-slide">
                                    <a href="<?= $finalURL ?>/pages/product-view.php?id_produto=<?= $jogo["id_produto"] ?>&categoria=<?= $jogo["categoria"] ?>" class="product-card">
                                        <div class="product-image">
                                            <img src="<?= $finalURL ?>/images/produtos/<?= $jogo["imagem_principal"] ?>" alt="<?= $jogo["nome"] ?>">

                                            <?php if ($jogo["status_promocao"] == 1): ?>
                                                <span class="promo-badge"><?= round($jogo["desconto"]) . "% OFF" ?></span>
                                            <?php endif ?>
                                        </div>

                                        <div class="product-details">
                                            <h2 class="product-title"><?= $jogo["nome"] ?></h2>
                                            <div class="product-badges-wrapper">
                                                <?php if ($jogo["plataforma"] != null): ?>
                                                    <div class="badge-icon-container"><i class="fa-brands fa-<?= explode(" ", strtolower($jogo["plataforma"] == "PC" ? "windows" : $jogo["plataforma"]))[0] ?> product-icon-badge"></i></div>
                                                <?php endif ?>
                                            </div>

                                            <!-- Para mim não esquecer o cálculo de % -> ((Preço antigo - Preço Atual) / Preço Antigo) * 100  -->
                                            <div class="product-prices-wrapper">
                                                <?php if ($jogo["status_promocao"] == 1): ?>
                                                    <span id="product-previous-price" class="product-price previous">R$ <?= $jogo["preco_venda"] ?></span>
                                                    <span id="product-current-price" class="product-price current">R$ <?= $jogo["preco_promocao"] ?></span>
                                                <?php else: ?>
                                                    <span id="product-previous-price" class="product-price previous"></span>
                                                    <span id="product-current-price" class="product-price current">R$ <?= $jogo["preco_venda"] ?></span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            <?php endforeach ?>
                        </div>

                        <!-- Botões de Paginação -->
                        <div id="p-pagination-prev" class="swiper-button-prev pag-button"></div>
                        <div id="p-pagination-next" class="swiper-button-next pag-button"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção de Consoles -->
        <section id="products-consoles" class="section-space">
            <div class="container">
                <div id="consoles-content">
                    <div class="section-title-container">
                        <i class="fa-solid fa-tags icon-section"></i>
                        <h2 class="section-title">Consoles em Promoção</h2>
                    </div>

                    <div class="swiper products-swiper">
                        <div class="swiper-wrapper">
                            <?php
                            foreach ($consoles as $console):

                            ?>

                                <!-- Produto inteiro -->
                                <div class="swiper-slide product-slide">
                                    <a href="<?= $finalURL ?>/pages/product-view.php?id_produto=<?= $console["id_produto"] ?>&categoria=<?= $console["categoria"] ?>" class="product-card">
                                        <div class="product-image">
                                            <img src="<?= $finalURL ?>/images/produtos/<?= $console["imagem_principal"] ?>" alt="<?= $console["nome"] ?>">

                                            <?php if ($console["status_promocao"] == 1): ?>
                                                <span class="promo-badge"><?= round($console["desconto"]) ?>% OFF</span>
                                            <?php endif ?>
                                        </div>

                                        <div class="product-details">
                                            <h2 class="product-title"><?= $console["nome"] ?></h2>
                                            <div class="product-badges-wrapper">
                                                <?php if ($console["plataforma"] != null): ?>
                                                    <div class="badge-icon-container"><i class="fa-brands fa-<?= explode(" ", strtolower($console["plataforma"]))[0] ?> product-icon-badge"></i></div>
                                                <?php endif ?>
                                            </div>

                                            <!-- Para mim não esquecer o cálculo de % -> ((Preço antigo - Preço Atual) / Preço Antigo) * 100  -->
                                            <div class="product-prices-wrapper">
                                                <?php if ($console["status_promocao"] == 1): ?>
                                                    <span id="product-previous-price" class="product-price previous">R$ <?= $console["preco_venda"] ?></span>
                                                    <span id="product-current-price" class="product-price current">R$ <?= $console["preco_promocao"] ?></span>
                                                <?php else: ?>
                                                    <span id="product-previous-price" class="product-price previous"></span>
                                                    <span id="product-current-price" class="product-price current">R$ <?= $console["preco_venda"] ?></span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            <?php endforeach ?>
                        </div>

                        <!-- Botões de Paginação -->
                        <div id="p-pagination-prev" class="swiper-button-prev pag-button"></div>
                        <div id="p-pagination-next" class="swiper-button-next pag-button"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção de Sobre -->
        <section id="about" class="section-space">
            <div class="container">
                <div id="about-content">
                    <div class="section-title-container">
                        <i class="fa-solid fa-users icon-section"></i>
                        <h2 class="section-title">Sobre nós</h2>
                    </div>

                    <div class="panels-container">
                        <div class="panel p1">
                            <span class="panel-badge">Nosso propósito</span>

                            <h3 class="panel-label">Transformar o prazer de jogar mais acessível.</h3>
                            <a href="#" class="panel-link">
                                Conheça nossa história
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>

                        <div class="panel p2">
                            <span class="panel-badge">Desde</span>

                            <h3 class="panel-label">2026</h3>
                        </div>

                        <div class="panel p3">
                            <span class="panel-badge">Produto vendidos</span>

                            <h3 class="panel-label">+50 mil</h3>
                        </div>

                        <div class="panel p4">
                            <span class="panel-badge">Últimas avaliações</span>

                            <div class="av-container">
                                <p class="panel-av">"De todas as lojas que procurei, aqui foi onde encontrei tudo o que eu queria e com um ótimo preço!"</p>

                                <div class="av-user-container">
                                    <span class="av-user">Gabriel Correia</span>
                                    <span class="av-user-date">Hoje, 10:30</span>
                                </div>
                            </div>
                        </div>

                        <div class="panel p5" id="panel-w-img">
                            <h3 class="panel-label big-label">O Brasil também joga!</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Seção de Contato -->
        <section id="contact" class="section-space">
            <div class="container">
                <div id="contact-content">
                    <!-- Contato com a empresa -->
                    <div id="contact-content">
                        <div class="section-title-container">
                            <i class="fa-solid fa-message icon-section"></i>
                            <h2 class="section-title">Fale com a gente</h2>
                        </div>

                        <div class="contact-wrapper">
                            <div class="contact-image">
                                <img src="./assets/images/contato-picture.jpg" alt="Imagem do Contato" loading="lazy">
                            </div>

                            <form action="" method="post" id="contact-form">
                                <input type="text" name="contact-name" id="contact-name" placeholder="Nome" autocomplete="off">
                                <input type="email" name="contact-email" id="contact-email" placeholder="Insira seu e-mail" autocomplete="off">
                                <textarea name="contact-message" id="contact-message" placeholder="Envie-nos uma mensagem"></textarea>
                                <button type="submit" id="contact-submit" class="default-button">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "components/Footer.php" ?>

    <!-- SwiperJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

    <!-- My Script -->
    <script src="custom/js/global.js"></script>
    <script src="custom/js/home.js"></script>
    <script src="custom/js/message-box.js"></script>
</body>

</html>