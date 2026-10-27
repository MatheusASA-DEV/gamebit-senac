<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../connection/connection.php";
require_once __DIR__ . "/../admin/produto/RepositorioProduto.php";

$id = $_GET["id_produto"];
$repos = new RepositorioProduto($pdo);
$produto = $repos->Consultar($id);

// Para busca relativa
$relativeCategory = $_GET["categoria"];
$relativeProducts = $repos->ConsultarRelacionadosCategoria($relativeCategory, $id, 10);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta author="Matheus de Andrade Silva Arruda">
   <title>GameBit | Visualizar produto</title>

   <!-- Google Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
      rel="stylesheet">

   <!-- Font Awesome Icons -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">

   <!-- SwiperJS Styles -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />

   <!-- My Styles -->
   <link rel="stylesheet" href="../custom/css/global.css">
   <link rel="stylesheet" href="../custom/css/product-view.css">
</head>

<body>
   <?php include_once "../components/Header.php" ?>

   <main>
      <!-- Visualizador de Produto -->
      <section id="view">
         <div class="container">
            <div id="view-content" hidden>
               <div class="product-photo-area">
                  <div id="big-image-container">
                     <img src="<?= $finalURL ?>/images/produtos/<?= $produto["imagem_principal"] ?>" alt="Imagem do Produto" loading="eager">
                  </div>

                  <div id="images-tracker">
                     <div class="image-mini selected">
                        <img src="<?= $finalURL ?>/images/produtos/<?= $produto["imagem_principal"] ?>" alt="Miniatura da Imagem do Produto" loading="eager">
                     </div>

                     <div class="image-mini">
                        <img src="<?= $finalURL ?>/images/produtos/<?= $produto["imagem_2"] ?>" alt="Miniatura da Imagem do Produto" loading="eager">
                     </div>

                     <div class="image-mini">
                        <img src="<?= $finalURL ?>/images/produtos/<?= $produto["imagem_3"] ?>" alt="Miniatura da Imagem do Produto" loading="eager">
                     </div>

                     <div class="image-mini">
                        <img src="<?= $finalURL ?>/images/produtos/<?= $produto["imagem_4"] ?>" alt="Miniatura da Imagem do Produto" loading="eager">
                     </div>
                  </div>
               </div>

               <div class="product-info-container">
                  <span id="stock-available" <?= $produto["estoque"] <= 15 ? 'class="lower-stock"' : '' ?> >Restam <strong><?= $produto["estoque"] ?></strong> unid.</span>

                  <h2 id="product-title"><?= $produto["nome"] ?></h2>

                  <div id="product-prices">
                     <?php if ($produto["status_promocao"] == 1): ?>
                        <span id="display-previous-price" class="product-price previous">R$ <?= $produto["preco_venda"] ?></span>

                        <div class="product-page-price-badge">
                           <span id="display-current-price" class="product-price current">R$ <?= $produto["preco_promocao"] ?></span>

                           <!-- Desconto% = ((Preço Original - Preço Final) / 100) * 100 -->
                           <span class="view-page-price-badge"><?= round($produto["desconto"]) . "% OFF" ?></span>
                        </div>

                     <?php else: ?>
                        <span id="display-previous-price" class="product-price previous"></span>

                        <div class="product-page-price-badge">
                           <span id="display-current-price" class="product-price current">R$ <?= $produto["preco_venda"] ?></span>
                        </div>
                     <?php endif ?>
                  </div>

                  <button type="button" id="buy-button" class="default-button" aria-label="Botão de realizar compra de produto selecionado">Comprar Agora</button>
               </div>
            </div>

            <div class="product-details-area">
               <button type="button" id="show-main-details" class="default-button">
                  <i class="fa-solid fa-circle-plus icon-details"></i>
                  Características Gerais
               </button>

               <div id="main-details" class="product-main-details">
                  <div class="details-body">
                     <p class="detail">
                        <strong class="detail-label">Descrição</strong>
                        <br>
                        <?= $produto["descricao"] != "" ? $produto["descricao"] : "Este produto ainda não possui uma descrição..." ?>
                     </p>

                     <?php if ($produto["marca"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Marca</strong>
                           <br>
                           <?= $produto["marca"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["voltagem"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Voltagem</strong>
                           <br>
                           <?= $produto["voltagem"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["desenvolvedor"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Desenvolvido por</strong>
                           <br>
                           <?= $produto["desenvolvedor"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["plataforma"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Plataforma compatível</strong>
                           <br>
                           <?= $produto["plataforma"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["genero"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Genêro de Jogo</strong>
                           <br>
                           <?= $produto["genero"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["cpu_min"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">CPU Mínima</strong>
                           <br>
                           <?= $produto["cpu_min"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["gpu_min"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">GPU Mínima</strong>
                           <br>
                           <?= $produto["gpu_min"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["ram_min"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Memória RAM Mínima</strong>
                           <br>
                           <?= $produto["ram_min"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["so_min"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Sistema Operacional Compatível</strong>
                           <br>
                           <?= $produto["so_min"] ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["leitor"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Possui leitor de discos</strong>
                           <br>
                           <?= $produto["leitor"] == 1 ? "Sim" : "Não" ?>
                        </p>
                     <?php endif ?>

                     <?php if ($produto["armazenamento"] != null): ?>
                        <p class="detail">
                           <strong class="detail-label">Armazenamento</strong>
                           <br>
                           <?= $produto["armazenamento"] ?>
                        </p>
                     <?php endif ?>
                  </div>
               </div>
            </div>
         </div>
      </section>

      <!-- Seção de Produtos Relacionados -->
      <section id="related-products" class="section-space">
         <div class="container">
            <div id="consoles-content">
               <div class="section-title-container">
                  <i class="fa-solid fa-binoculars icon-section"></i>
                  <h2 class="section-title">Veja também</h2>
               </div>

               <div class="swiper products-swiper">
                  <div class="swiper-wrapper">
                    <?php foreach ($relativeProducts as $rel): ?>
                     <div class="swiper-slide product-slide">
                        <a href="<?= $finalURL ?>/pages/product-view.php?id_produto=<?= $rel["id_produto"] ?>&categoria=<?= $rel["categoria"] ?>" class="product-card">
                           <div class="product-image">
                              <img src="<?= $finalURL ?>/images/produtos/<?= $rel["imagem_principal"] ?>" alt="<?= $rel["nome"] ?>">

                              <?php if ($rel["status_promocao"] == 1): ?>
                                <span class="promo-badge"><?= round($rel["desconto"]) . "% OFF" ?></span>
                              <?php endif ?>
                           </div>

                           <div class="product-details">
                              <h2 class="product-title"><?= $rel["nome"] ?></h2>
                              <div class="product-badges-wrapper">
                                <?php if ($rel["plataforma"] != null): ?>
                                    <div class="badge-icon-container"><i class="fa-brands fa-<?= explode(" ", strtolower($rel["plataforma"]))[0] ?> product-icon-badge"></i></div>
                                <?php endif ?>
                              </div>

                              <!-- Para mim não esquecer o cálculo de % -> ((Preço antigo - Preço Atual) / Preço Antigo) * 100  -->
                              <div class="product-prices-wrapper">
                                <?php if ($rel["status_promocao"] == 1): ?>
                                    <span id="product-previous-price" class="product-price previous">R$ <?= $rel["preco_venda"] ?></span>
                                    <span id="product-current-price" class="product-price current">R$ <?= $rel["preco_promocao"] ?></span>
                                    <?php else: ?>
                                    <span id="product-previous-price" class="product-price previous"></span>
                                    <span id="product-current-price" class="product-price current">R$ <?= $rel["preco_venda"] ?></span>
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
   </main>

   <?php include_once "../components/Footer.php" ?>
   <!-- SwiperJS Script -->
   <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

   <!-- My Script -->
   <script src="../custom/js/global.js"></script>
   <script src="../custom/js/product-view.js"></script>
</body>

</html>