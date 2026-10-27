<?php

session_start();
require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioCategoria.php";

if (isset($_POST["delete_id"])) {
    $id = $_POST["delete_id"];

    try {
        $repos = new RepositorioCategoria($pdo);
        $res = $repos->Deletar($id);

        $_SESSION["message"] =
        '
        <div class="message-box success shown">
            <h4 class="message-title">Feito!</h4>
            <p class="message-body">Registro excluído com sucesso.</p>
        </div>
        ';
    } catch (Exception) {
        $sql = "SELECT c.nome, COUNT(*) 'qtd' FROM categoria c JOIN produto p ON p.id_categoria = c.id_categoria WHERE c.id_categoria = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        $res = $stmt->fetch();

        $_SESSION["message"] =
        '
        <div class="message-box fail shown">
            <h4 class="message-title">Erro!</h4>
            <p class="message-body">Não foi possível excluir este registro. <br> Detalhes: A categoria '. $res["nome"] .' possui '. $res["qtd"] .' produtos cadastrados.</p>
        </div>
        ';
    } finally {
        header("Location: consultar-categoria.php");
        exit;
    }
}
