<?php 

require_once __DIR__ . "/../../connection/connection.php";
if (!isset($_SESSION)) session_start();

// Essa página só deve ser acessada se um usuário estiver logado
if (!$_SESSION["USER"])
{
    $_SESSION["notAuth"] =
    '
    <div id="login-status-message-container">
        <span class="status-message">OPS! Somente administradores podem acessar esta página!</span>
    </div>
    ';
    
    header("Location: ../Index.php");
}

date_default_timezone_set("America/Sao_Paulo");

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
    <link rel="stylesheet" href="../../custom/css/overview-dashboard.css">
</head>

<body>
    <div id="dashboard-container">
        <?php include "../../components/DashboardSidebar.php" ?>
        
        <main>
            <?php if (isset($_SESSION["notAdmin"])): ?>
                <p class="not-admin-message"><?= $_SESSION["notAdmin"] ?></p>

                <?php 
                unset($_SESSION["notAdmin"]);
                exit;
                ?>
            <?php endif ?>

            <!-- Dashboard começa aqui -->
            <div id="dashboard-content">
                <div class="data-title">
                    <span class="data-sup-label">Última atualização: <?= date("d/m/Y H:i") ?></span>
                    <h2 class="data-label">Dashboard do Sistema</h2>
                </div>

                <div class="charts-grid">
                    <!-- Produtos com estoque baixo (5) -->
                    <div class="data-container">
                        <div class="data-title">
                            <span class="data-sup-label">Visão geral</span>
                            <h2 class="data-label">Produtos com Estoque Baixo</h2>
                        </div>
    
                        <div class="chart-container">
                            <canvas id="product-most-sold"></canvas>
                        </div>
                    </div>
                </div>

                <div class="info-block main-block">
                    <?php 
                    
                    $sql = "SELECT SUM(preco_custo) 'inventario' FROM produto";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    $inv = $stmt->fetchColumn();

                    ?>

                    <h4 class="info-label">Valor do inventário da loja</h4>
                    <span class="info-data main-data">R$ <?= $inv ?></span>
                </div>

                <div id="dashboard-info-container">
                    <div class="info-block ib1">
                        <?php 
                        
                        $sql = "SELECT COUNT(id_venda) 'vendas' FROM venda";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $vendasT = $stmt->fetchColumn();

                        ?>
                        <h4 class="info-label">Total de vendas nas últimas 24h</h4>
                        <span class="info-data"><?= $vendasT ?></span>
                    </div>

                    <div class="info-block ib2">
                        <?php 
                    
                        $sql = "SELECT COUNT(id_cliente) 'clientes' FROM cliente";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $clientesT = $stmt->fetchColumn();

                        ?>
                        <h4 class="info-label">Total de clientes cadastrados</h4>
                        <span class="info-data"><?= $clientesT ?></span>
                    </div>

                    <div class="info-block ib3">
                        <?php 
                    
                        $sql = "SELECT COUNT(id_func) 'funcionarios' FROM funcionario";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $funcs = $stmt->fetchColumn();

                        ?>

                        <h4 class="info-label">Total de funcionários cadastrados</h4>
                        <span class="info-data"><?= $funcs ?></span>
                    </div>

                    <div class="info-block ib4">
                        <?php 
                    
                        $sql = "SELECT COUNT(id_produto) 'produtos' FROM produto";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        $produtosT = $stmt->fetchColumn();

                        ?>
                        <h4 class="info-label">Produtos disponíveis na loja</h4>
                        <span class="info-data"><?= $produtosT ?></span>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ChartJS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Script Dashboard -->
    <script src="../../custom/js/dashboard.js"></script>
    <script src="../../custom/js/message-box.js"></script>
    <script src="../../custom/js/overview-dashboard.js"></script>
</body>

</html>