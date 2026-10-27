<?php 

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioProduto.php";

try {
    $repos = new RepositorioProduto($pdo);
    $res = $repos->Filtrar($_GET);
    http_response_code(200);

    if (count($res) > 0) {
        foreach ($res as $produto) {
            echo
            '
            <tr>
                <td>' . $produto["id_produto"] . '</td>

                <td>' .
                    '<div class="table-photo-container">
                        <img src="../../images/produtos/' . $produto["imagem_principal"] . '" class="table-photo">
                    </div>'
                . '</td>

                <td>' . $produto["categoria"] . '</td>

                <td>' . $produto["nome"] . '</td>

                <td>' . number_format($produto["estoque"], 0, '', '.') . '</td>

                <td> R$ ' . number_format($produto["preco_custo"], 2, ',', '.') . '</td>

                <td>' . $produto["lucro"] . '%</td>

                <td> R$ ' . number_format($produto["preco_venda"], 2, ',', '.') . '</td>

                <td>' . ($produto["status_promocao"] == 1 ? "Sim" : "Não") . '</td>

                <td>' . ($produto["desconto"] != null ? ($produto["desconto"] . '%') : "N/A") . '</td>

                <td>R$ ' . (number_format($produto["preco_promocao"], 2, ',', '.') ?? "N/A") . '</td>

                <td>' . ($produto["descricao"] == "" ? "Não possui" : $produto["descricao"]) . '</td>

                <td>' . ($produto["marca"] ?? "N/A") . '</td>

                <td>' . ($produto["plataforma"] ?? "N/A") . '</td>

                <td>' . ($produto["genero"] ?? "N/A") . '</td>

                <td>' . ($produto["desenvolvedor"] ?? "N/A") . '</td>

                <td>' . ($produto["cpu_min"] == "" ? "N/A" : $produto["cpu_min"]) . '</td>

                <td>' . ($produto["gpu_min"] == "" ? "N/A" : $produto["gpu_min"]) . '</td>

                <td>' . ($produto["ram_min"] == "" ? "N/A" : $produto["ram_min"]) . '</td>

                <td>' . ($produto["so_min"] == "" ? "N/A" : $produto["so_min"]) . '</td>

                <td>' . ($produto["armazenamento"] ?? "N/A") . '</td>

                <td>' . ($produto["leitor"] == 0 ? "Não" : "Sim") . '</td>

                <td>' . ($produto["voltagem"] == "" ? "N/A" : $produto["voltagem"]) . '</td>

                <td>' . $produto["data_cadastro"] . '</td>

                <td>' . ($produto["status"] == 1 ? "<span class='status-badge active'>Ativo</span>" : "<span class='status-badge inactive'>Inativo</span>") . '</td>

                <td>' .
                '<div class="actions-wrapper">
                     <a href="editar-produto.php?id_produto=' . $produto["id_produto"] . '" class="table-action-link edit-link"><i class="fa-solid fa-pen-to-square icon-table"></i></a>

                     <form action="deletar-produto.php" method="post" style="display: inline-flex;">
                        <button type="submit" name="delete_id" value=' . $produto["id_produto"] . ' class="table-action-link delete-link" onclick="return confirm(\'Tem certeza?\')"><i class="fa-solid fa-trash icon-table"></i></button>
                     </form>
                  </div>'
                . '</td>
            </tr>
            ';
        }
    } else {
        echo
        '
        <tr class="row-no-info">
            <td class="table-info">
                Nenhum registro foi encontrado...
            </td>
        </tr>
        ';
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    http_response_code(500);
}

?>