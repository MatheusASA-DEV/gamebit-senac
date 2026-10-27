<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../connection/connection.php";
require_once __DIR__ . "/../admin/produto/RepositorioProduto.php";

$nome = $_GET["q"] ?? "";

// Configuração da Paginação
$limit = 16;

// Verificando se há algum valor para "page-num" sendo passado via GET (URL)
$page = isset($_GET["page-num"]) ? $_GET["page-num"] : 1;

// Verificação para evitar páginas 0 ou com número negativo
if ($page < 1) $page = 1;

// Contar quantos produtos há no Banco de Dados
// Aqui continua contando a partir do nome apenas, não pelo filtro, ou seja, ao procurar por algo LIKE %''%, retorna tudo, então a paginação entende que recebeu mais que o limite, portanto gera paginação... bruh
$sqlCount = "SELECT COUNT(*) 'total' FROM produto WHERE status = 1 AND nome LIKE :nome";
$stmt = $pdo->prepare($sqlCount);
$stmt->execute([":nome" => "%" . $nome . "%"]);

$res = $stmt->fetch();

// Cálculo para saber quantidade de páginas para mostrar os produtos
$pagesAmount = ceil($res["total"] / $limit);

// Evitando acesso à uma página maior que a quantidade de páginas possíveis
if ($page > $pagesAmount && $pagesAmount > 0) $page = $pagesAmount;

// OFFSET
$offset = ($page - 1) * $limit;


// Filtros do Grid
$sql = "SELECT p.*, p.id_categoria 'categoria', m.nome 'marca', pl.nome 'plataforma', g.nome 'genero', d.nome 'desenvolvedor' FROM produto p JOIN categoria c ON p.id_categoria = c.id_categoria LEFT JOIN marca m ON p.id_marca = m.id_marca LEFT JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma LEFT JOIN genero_jogo g ON p.id_genero = g.id_genero LEFT JOIN desenvolvedor d ON p.id_desenvolvedor = d.id_desenvolvedor WHERE p.status = 1 AND p.nome LIKE :n";

// Pegando via GET os filtros
$categoriaFilter = $_GET["categoria-filter"] ?? null;
$generoFilter = $_GET["genero-filter"] ?? null;
$devFilter = $_GET["desenvolvedor-filter"] ?? null;
$marcaFilter = $_GET["marca-filter"] ?? null;

$plataformaFilter = $_GET["plataforma_filter"] ?? null;
$priceFilter = (isset($_GET["price-filter"]) && $_GET["price-filter"] == 1) ? "DESC" : "ASC";

if (is_array($categoriaFilter) && count($categoriaFilter) > 0) {
    $categorias = array_map('intval', $categoriaFilter);

    $categoriasList = implode(",", $categorias);
    $sql .= " AND p.id_categoria IN ($categoriasList)";
}

if (is_array($generoFilter) && count($generoFilter) > 0) {
    $generos = array_map('intval', $generoFilter);

    $generosList = implode(",", $generos);
    $sql .= " AND p.id_genero IN ($generosList)";
}

if (is_array($devFilter) && count($devFilter) > 0) {
    $dev = array_map('intval', $devFilter);

    $devList = implode(",", $dev);
    $sql .= " AND p.id_desenvolvedor IN ($devList)";
}

if (is_array($marcaFilter) && count($marcaFilter) > 0) {
    $marcas = array_map('intval', $marcaFilter);

    $marcasList = implode(",", $marcas);
    $sql .= " AND p.id_marca IN ($marcasList)";
}

if (is_array($plataformaFilter) && count($plataformaFilter) > 0) {
    $plataformas = array_map('intval', $plataformaFilter);

    $plataformasList = implode(",", $plataformas);
    $sql .= " AND p.id_plataforma IN ($plataformasList)";
}

// Tem que ficar por último devido à ordem do SQL do ORDER BY logo após WHERE
if ($priceFilter != "" && $priceFilter != null) {
    $sql .= " ORDER BY p.preco_venda " . $priceFilter;
}

$stmt = $pdo->prepare($sql);
$stmt->execute([":n" => "%" . $nome . "%"]);
$resFilter = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Matheus de Andrade Silva Arruda">
    <title>GameBit | Ver produtos</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css" integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- My Styles -->
    <link rel="stylesheet" href="../custom/css/global.css">
    <link rel="stylesheet" href="../custom/css/product-grid.css">
</head>

<body>
    <?php include_once "../components/Header.php" ?>

    <main>
        <section id="products-grid" class="section-space">
            <div class="container">
                <div id="products-grid-content">
                    <aside id="filter-sidebar">
                        <div class="sidebar-title-container">
                            <h2 class="sidebar-title">Filtros</h2>
                            <button type="button" id="close-sidebar-button"><i class="fa-solid fa-xmark icon-menu"></i></button>
                        </div>

                        <form action="Search.php" method="GET" id="filter-form" class="filters-wrapper">
                            <input type="hidden" name="filter-hidden" value="filter-yes">
                            <input type="hidden" name="q" value="<?= $nome ?>">

                            <!-- Por preço -->
                            <div class="filter-group">
                                <button type="button" class="default-button filter-button-accordion">
                                    Ordenar por preço
                                    <i class="fa-solid fa-chevron-right icon-filter icon-accordion opened"></i>
                                </button>

                                <div class="filter-options active">
                                    <div class="filter-container">
                                        <div class="filter-body">
                                            <label class="price-filter-radio">
                                                <input type="radio" name="price-filter" value="1" hidden>
                                                <i class="fa-solid fa-arrow-down icon-filter"></i>
                                                Do maior para o menor
                                            </label>

                                            <label class="price-filter-radio">
                                                <input type="radio" name="price-filter" value="0" hidden>
                                                <i class="fa-solid fa-arrow-up icon-filter"></i>
                                                Do menor para o maior
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Por categoria -->
                            <div class="filter-group">
                                <button type="button" class="default-button filter-button-accordion">
                                    Categoria
                                    <i class="fa-solid fa-chevron-right icon-filter icon-accordion"></i>
                                </button>

                                <div class="filter-options">
                                    <div class="filter-container">
                                        <div class="filter-body">
                                            <?php

                                            $sql = "SELECT id_categoria, nome FROM categoria WHERE status = 1";

                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();

                                            $categorias = $stmt->fetchAll();

                                            ?>

                                            <?php foreach ($categorias as $categoria): ?>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" name="categoria-filter[]" class="filter-checkbox" value="<?= $categoria["id_categoria"] ?>">
                                                    <?= ucfirst($categoria["nome"]) ?>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Por genêro de jogo -->
                            <div class="filter-group">
                                <button type="button" class="default-button filter-button-accordion">
                                    Genêro de Jogo
                                    <i class="fa-solid fa-chevron-right icon-filter icon-accordion"></i>
                                </button>

                                <div class="filter-options">
                                    <div class="filter-container">
                                        <div class="filter-body">
                                            <?php

                                            $sql = "SELECT id_genero, nome FROM genero_jogo WHERE status = 1";

                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();

                                            $generos = $stmt->fetchAll();

                                            ?>

                                            <?php foreach ($generos as $genero): ?>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" name="genero-filter[]" class="filter-checkbox" value="<?= $genero["id_genero"] ?>">
                                                    <?= ucfirst($genero["nome"]) ?>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Por desenvolvedor -->
                            <div class="filter-group">
                                <button type="button" class="default-button filter-button-accordion">
                                    Desenvolvedor
                                    <i class="fa-solid fa-chevron-right icon-filter icon-accordion"></i>
                                </button>

                                <div class="filter-options">
                                    <div class="filter-container">
                                        <div class="filter-body">
                                            <?php

                                            $sql = "SELECT id_desenvolvedor, nome FROM desenvolvedor WHERE status = 1";

                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();

                                            $devs = $stmt->fetchAll();

                                            ?>

                                            <?php foreach ($devs as $dev): ?>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" name="desenvolvedor-filter[]" class="filter-checkbox" value="<?= $dev["id_desenvolvedor"] ?>">
                                                    <?= ucfirst($dev["nome"]) ?>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Por marca -->
                            <div class="filter-group">
                                <button type="button" class="default-button filter-button-accordion">
                                    Marca
                                    <i class="fa-solid fa-chevron-right icon-filter icon-accordion"></i>
                                </button>

                                <div class="filter-options">
                                    <div class="filter-container">
                                        <div class="filter-body">
                                            <?php

                                            $sql = "SELECT id_marca, nome FROM marca WHERE status = 1";

                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();

                                            $marcas = $stmt->fetchAll();

                                            ?>

                                            <?php foreach ($marcas as $marca): ?>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" name="marca-filter[]" class="filter-checkbox" value="<?= $marca["id_marca"] ?>">
                                                    <?= ucfirst($marca["nome"]) ?>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Por plataforma -->
                            <div class="filter-group">
                                <button type="button" class="default-button filter-button-accordion">
                                    Plataforma
                                    <i class="fa-solid fa-chevron-right icon-filter icon-accordion"></i>
                                </button>

                                <div class="filter-options">
                                    <div class="filter-container">
                                        <div class="filter-body">
                                            <?php

                                            $sql = "SELECT id_plataforma, nome FROM plataforma WHERE status = 1";

                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();

                                            $plataformas = $stmt->fetchAll();

                                            ?>

                                            <?php foreach ($plataformas as $plataforma): ?>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" name="plataforma-filter[]" class="filter-checkbox" value="<?= $plataforma["id_plataforma"] ?>">
                                                    <?= ucfirst($plataforma["nome"]) ?>
                                                </label>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Botão Mobile Aplicar Filtros -->
                        <div class="mobile-filter-button-container">
                            <button type="button" id="mobile-apply-filters" class="default-button">Aplicar</button>
                        </div>
                    </aside>

                    <div id="product-grid-container">
                        <div class="search-term-container">
                            <p class="search-label">Resultados para: </p>
                            <span class="search-term"><?= $nome ?></span>
                        </div>

                        <button id="open-filters" class="default-button">
                            <i class="fa-solid fa-sliders icon-menu"></i>
                            Filtros
                        </button>

                        <div class="product-grid">
                            <?php foreach ($resFilter as $p): ?>
                                <a href="<?= $finalURL ?>/pages/product-view.php?id_produto=<?= $p["id_produto"] ?>&categoria=<?= $p["categoria"] ?>" class="product-card">
                                    <div class="product-image">
                                        <img src="<?= $finalURL ?>/images/produtos/<?= $p["imagem_principal"] ?>" alt="<?= $p["nome"] ?>">

                                        <?php if ($p["status_promocao"] == 1): ?>
                                            <span class="promo-badge"><?= round($p["desconto"]) . "% OFF" ?></span>
                                        <?php endif ?>
                                    </div>

                                    <div class="product-details">
                                        <h2 class="product-title"><?= $p["nome"] ?></h2>
                                        <div class="product-badges-wrapper">
                                            <?php if ($p["plataforma"] != null): ?>
                                                <div class="badge-icon-container"><i class="fa-brands fa-<?= explode(" ", strtolower($p["plataforma"]))[0] ?> product-icon-badge"></i></div>
                                            <?php endif ?>
                                        </div>

                                        <!-- Para mim não esquecer o cálculo de % -> ((Preço antigo - Preço Atual) / Preço Antigo) * 100  -->
                                        <div class="product-prices-wrapper">
                                            <?php if ($p["status_promocao"] == 1): ?>
                                                <span id="product-previous-price" class="product-price previous">R$ <?= $p["preco_venda"] ?></span>
                                                <span id="product-current-price" class="product-price current">R$ <?= $p["preco_promocao"] ?></span>
                                            <?php else: ?>
                                                <span id="product-previous-price" class="product-price previous"></span>
                                                <span id="product-current-price" class="product-price current">R$ <?= $p["preco_venda"] ?></span>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach ?>
                        </div>

                        <div class="products-pagination">
                            <?php if ($pagesAmount > 1): ?>
                                <nav>
                                    <ul class="pagination-list">

                                        <li class="pagination-item <?= $page <= 1 ? 'disabled-pag' : '' ?>">
                                            <a href="?page-num=<?= $page - 1 ?>" class="page-link"><i class="fa-solid fa-angle-left pag-icon"></i></a>
                                        </li>

                                        <?php for ($i = 1; $i <= $pagesAmount; $i++): ?>
                                            <li class="pagination-item">
                                                <a href="?page-num=<?= $i ?>" class="page-link <?= $page == $i ? 'current-pag' : '' ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor ?>

                                        <li class="pagination-item <?= $page >= $pagesAmount ? 'disabled-pag' : '' ?>">
                                            <a href="?page-num=<?= $page + 1 ?>" class="page-link"><i class="fa-solid fa-angle-right pag-icon"></i></a>
                                        </li>

                                    </ul>
                                </nav>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once "../components/Footer.php" ?>

    <!-- My Script -->
    <script src="../custom/js/global.js"></script>
    <script src="../custom/js/product-grid.js"></script>

    <!-- Enviar Filtros -->
    <script>
        /** @type {HTMLFormElement} */
        const filterForm = document.getElementById("filter-form");
        const submitButton = document.getElementById("mobile-apply-filters");

        submitButton.addEventListener("click", () => {
            filterForm.submit();
        })
    </script>
</body>

</html>