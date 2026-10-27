<?php 

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioGeneroJogo.php";

try {
    $repos = new RepositorioGeneroJogo($pdo);
    $res = $repos->Filtrar($_GET);
    http_response_code(200);

    if (count($res) > 0) {
        foreach ($res as $genero) {
            echo
            '
            <tr>
                <td>' . $genero["id_genero"] . '</td>

                <td>' . $genero["nome"] . '</td>

                <td>' . $genero["data_cadastro"] . '</td>

                <td>' . ($genero["status"] == 1 ? "<span class='status-badge active'>Ativo</span>" : "<span class='status-badge inactive'>Inativo</span>") . '</td>

                <td>' .
                '<div class="actions-wrapper">
                     <a href="editar-genero.php?id_genero=' . $genero["id_genero"] . '" class="table-action-link edit-link"><i class="fa-solid fa-pen-to-square icon-table"></i></a>

                     <form action="deletar-genero.php" method="post" style="display: inline-flex;">
                        <button type="submit" name="delete_id" value=' . $genero["id_genero"] . ' class="table-action-link delete-link" onclick="return confirm(\'Tem certeza?\')"><i class="fa-solid fa-trash icon-table"></i></button>
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