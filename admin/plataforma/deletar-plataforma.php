<?php

session_start();
require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioPlataforma.php";

if (isset($_POST["delete_id"])) {
    $id = $_POST["delete_id"];

    try {
        $repos = new RepositorioPlataforma($pdo);
        $res = $repos->Deletar($id);

        $_SESSION["message"] =
        '
        <div class="message-box success shown">
            <h4 class="message-title">Feito!</h4>
            <p class="message-body">Registro excluído com sucesso.</p>
        </div>
        ';
    } catch (Exception) {
        $sql = "SELECT pl.nome, COUNT(*) 'qtd' FROM plataforma pl JOIN produto pr ON pr.id_plataforma = pl.id_plataforma WHERE p.id_plataforma = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        $res = $stmt->fetch();

        $_SESSION["message"] =
        '
        <div class="message-box fail shown">
            <h4 class="message-title">Erro!</h4>
            <p class="message-body">Não foi possível excluir este registro. <br> Detalhes: A plataforma '. $res["nome"] .' possui '. $res["qtd"] .' produtos cadastrados.</p>
        </div>
        ';
    } finally {
        header("Location: consultar-plataforma.php");
        exit;
    }
}
