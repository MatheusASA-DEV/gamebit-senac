<?php 

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioProduto.php";

$repos = new RepositorioProduto($pdo);
$produtos = $repos->ChartDataEstoque();

$nomes = [];
$estoques = [];

foreach ($produtos as $produto) {
    $nomes[] = $produto["nome"];
    $estoques[] = $produto["estoque"];
}

// O echo é o que retorna, nessa caso, o objeto que posso acessar assincronamente
echo json_encode([
    "nomes" => $nomes,
    "estoques" => $estoques
]);

?>