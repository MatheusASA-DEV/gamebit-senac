<?php

session_start();
require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioProduto.php";

if (isset($_POST["delete_id"])) {
    $id = $_POST["delete_id"];

    try {
        $repos = new RepositorioProduto($pdo);
        $res = $repos->Deletar($id);

        $_SESSION["message"] =
        '
        <div class="message-box success shown">
            <h4 class="message-title">Feito!</h4>
            <p class="message-body">Registro excluído com sucesso.</p>
        </div>
        ';
    } catch (Exception $e) {
        $_SESSION["message"] =
        '
        <div class="message-box fail shown">
            <h4 class="message-title">Erro!</h4>
            <p class="message-body">Não foi possível excluir este registro. <br> Detalhes: '. $e->getMessage() .'</p>
        </div>
        ';
    } finally {
        header("Location: consultar-produto.php");
        exit;
    }
}