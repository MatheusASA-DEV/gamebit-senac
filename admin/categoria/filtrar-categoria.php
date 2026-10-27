<?php 

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioCategoria.php";

try {
    $repos = new RepositorioCategoria($pdo);
    $res = $repos->Filtrar($_GET);
    http_response_code(200);

    if (count($res) > 0) {
        foreach ($res as $categoria) {
            echo
            '
            <tr>
                <td>' . $categoria["id_categoria"] . '</td>

                <td>' . $categoria["nome"] . '</td>

                <td>' . $categoria["data_cadastro"] . '</td>

                <td>' . ($categoria["status"] == 1 ? "<span class='status-badge active'>Ativo</span>" : "<span class='status-badge inactive'>Inativo</span>") . '</td>

                <td>' .
                '<div class="actions-wrapper">
                     <a href="editar-categoria.php?id_categoria=' . $categoria["id_categoria"] . '" class="table-action-link edit-link"><i class="fa-solid fa-pen-to-square icon-table"></i></a>

                     <form action="deletar-categoria.php" method="post" style="display: inline-flex;">
                        <button type="submit" name="delete_id" value=' . $categoria["id_categoria"] . ' class="table-action-link delete-link" onclick="return confirm(\'Tem certeza?\')"><i class="fa-solid fa-trash icon-table"></i></button>
                     </form>
                  </div>'
                . '</td>
            </tr>
            ';
        }
    } else {
        echo
        '
        <tr>
            <td class="table-info">
                Nenhum registro foi encontrado...
            </td>
        </tr>
        ';
    }
} catch (PDOException) {
    http_response_code(500);
}

?>