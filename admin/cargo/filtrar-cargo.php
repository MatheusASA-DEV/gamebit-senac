<?php 

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioCargo.php";

try {
    $repos = new RepositorioCargo($pdo);
    $res = $repos->Filtrar($_GET);
    http_response_code(200);

    if (count($res) > 0) {
        foreach ($res as $cargo) {
            echo
            '
            <tr>
                <td>' . $cargo["id_cargo"] . '</td>

                <td>' . $cargo["nome"] . '</td>

                <td>' . $cargo["observacao"] . '</td>

                <td>' . $cargo["data_cadastro"] . '</td>

                <td>' . ($cargo["status"] == 1 ? "<span class='status-badge active'>Ativo</span>" : "<span class='status-badge inactive'>Inativo</span>") . '</td>

                <td>' .
                '<div class="actions-wrapper">
                     <a href="editar-cargo.php?id_cargo=' . $cargo["id_cargo"] . '" class="table-action-link edit-link"><i class="fa-solid fa-pen-to-square icon-table"></i></a>

                     <form action="deletar-cargo.php" method="post" style="display: inline-flex;">
                        <button type="submit" name="delete_id" value=' . $cargo["id_cargo"] . ' class="table-action-link delete-link" onclick="return confirm(\'Tem certeza?\')"><i class="fa-solid fa-trash icon-table"></i></button>
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