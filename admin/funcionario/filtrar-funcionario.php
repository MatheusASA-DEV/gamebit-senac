<?php

require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioFuncionario.php";

try {
    $repos = new RepositorioFuncionario($pdo);
    $res = $repos->Filtrar($_GET);
    http_response_code(200);

    if (count($res) > 0) {
        foreach ($res as $funcionario) {
            echo
            '
            <tr>
                <td>' . htmlspecialchars($funcionario["id_func"]) . '</td>

                <td>' .
                     '<div class="table-photo-container">
                        <img src="../../images/funcionarios/' . $funcionario["foto"] . '" class="table-photo">
                     </div>'
                . '</td>

                <td>' . htmlspecialchars(empty($funcionario["nome_social"]) ? $funcionario["nome"] : $funcionario["nome_social"]) . '</td>

                <td>' . htmlspecialchars($funcionario["cargo"]) . '</td>

                <td>' . htmlspecialchars($funcionario["sexo"]) . '</td>

                <td>' . ($funcionario["cep"] != "00000-000" ? htmlspecialchars($funcionario["cep"]) : "N/A") . '</td>

                <td>' . ($funcionario["rg"] != "" ? htmlspecialchars($funcionario["rg"]) : "N/A") . '</td>

                <td>' . date('d/m/Y', strtotime($funcionario["data_nascimento"])) . '</td>

                <td>' . ($funcionario["estado_civil"] != "" ? htmlspecialchars($funcionario["estado_civil"]) : "N/A") . '</td>

                <td>' . ($funcionario["cidade"] != "" ? htmlspecialchars($funcionario["cidade"]) : "N/A") . '</td>

                <td>' . ($funcionario["estado"] != "" ? htmlspecialchars($funcionario["estado"]) : "N/A") . '</td>

                <td>' . ($funcionario["endereco"] != "" ? htmlspecialchars($funcionario["endereco"]) : "N/A") . '</td>

                <td>' . ($funcionario["numero"] != 0 ? htmlspecialchars($funcionario["numero"]) : "N/A") . '</td>

                <td>' . ($funcionario["bairro"] != "" ? htmlspecialchars($funcionario["bairro"]) : "N/A") . '</td>

                <td>' . ($funcionario["complemento"] != "" ? htmlspecialchars($funcionario["complemento"]) : "N/A") . '</td>

                <td>' . htmlspecialchars($funcionario["cep"]) . '</td>

                <td>' . ($funcionario["telefone_residencial"] != "" ? htmlspecialchars($funcionario["telefone_residencial"]) : "N/A") . '</td>

                <td>' . ($funcionario["telefone_celular"] != "" ? htmlspecialchars($funcionario["telefone_celular"]) : "N/A") . '</td>

                <td>' . htmlspecialchars($funcionario["usuario"]) . '</td>

                <td>' . htmlspecialchars($funcionario["email"]) . '</td>

                <td>' . htmlspecialchars($funcionario["senha"]) . '</td>

                <td>' . htmlspecialchars($funcionario["tipo_acesso"] == 0 ? 'Comum' : 'Administrador') . '</td>

                <td> R$ ' . number_format($funcionario["salario"], 2, ',', '.') . '</td>

                <td>' . htmlspecialchars($funcionario["data_cadastro"]) . '</td>

                <td>' . ($funcionario["status"] == 1 ? "<span class='status-badge active'>Ativo</span>" : "<span class='status-badge inactive'>Inativo</span>") . '</td>

                <td>' .
                '<div class="actions-wrapper">
                     <a href="editar-funcionario.php?id_func=' . $funcionario["id_func"] . '" class="table-action-link edit-link"><i class="fa-solid fa-pen-to-square icon-table"></i></a>

                     <form action="deletar-funcionario.php" method="post" style="display: inline-flex;">
                        <button type="submit" name="delete_id" value=' . $funcionario["id_func"] . ' class="table-action-link delete-link" onclick="return confirm(\'Tem certeza?\')"><i class="fa-solid fa-trash icon-table"></i></button>
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
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    http_response_code(500);
}
