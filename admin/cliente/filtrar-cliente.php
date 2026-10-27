<?php

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioCliente.php";

try {
    $repos = new RepositorioCliente($pdo);
    $res = $repos->Filtrar($_GET);
    http_response_code(200);

    if (count($res) > 0) {
        foreach ($res as $cliente) {
            echo
            '
            <tr>
                <td>' . htmlspecialchars($cliente["id_cliente"]) . '</td>

                <td>' . htmlspecialchars($cliente["nome"]) . '</td>

                <td>' . htmlspecialchars($cliente["sexo"]) . '</td>

                <td>' . htmlspecialchars($cliente["cpf"]) . '</td>

                <td>' . htmlspecialchars($cliente["rg"]) . '</td>

                <td>' . date('d/m/Y', strtotime($cliente["data_nascimento"])) . '</td>

                <td>' . htmlspecialchars($cliente["estado_civil"]) . '</td>

                <td>' . htmlspecialchars($cliente["cidade"]) . '</td>

                <td>' . htmlspecialchars($cliente["estado"]) . '</td>

                <td>' . htmlspecialchars($cliente["endereco"]) . '</td>

                <td>' . htmlspecialchars($cliente["numero"]) . '</td>

                <td>' . htmlspecialchars($cliente["bairro"]) . '</td>

                <td>' . htmlspecialchars($cliente["complemento"]) . '</td>

                <td>' . htmlspecialchars($cliente["cep"]) . '</td>

                <td>' . htmlspecialchars($cliente["telefone_residencial"]) . '</td>

                <td>' . htmlspecialchars($cliente["telefone_celular"]) . '</td>

                <td>' . htmlspecialchars($cliente["email"]) . '</td>

                <td>' . htmlspecialchars($cliente["senha"]) . '</td>

                <td>' . htmlspecialchars($cliente["data_cadastro"]) . '</td>

                <td>' . ($cliente["status"] == 1 ? "<span class='status-badge active'>Ativo</span>" : "<span class='status-badge inactive'>Inativo</span>") . '</td>

                <td>' .
                '<div class="actions-wrapper">
                     <a href="editar-cliente.php?id_cliente=' . $cliente["id_cliente"] . '" class="table-action-link edit-link"><i class="fa-solid fa-pen-to-square icon-table"></i></a>

                     <form action="deletar-cliente.php" method="post" style="display: inline-flex;">
                        <button type="submit" name="delete_id" value=' . $cliente["id_cliente"] . ' class="table-action-link delete-link" onclick="return confirm(\'Tem certeza?\')"><i class="fa-solid fa-trash icon-table"></i></button>
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