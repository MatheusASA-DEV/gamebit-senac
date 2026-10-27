<?php

session_start();
require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/RepositorioGeneroJogo.php";

if (isset($_POST["delete_id"])) {
    $id = $_POST["delete_id"];

    try {
        $repos = new RepositorioGeneroJogo($pdo);
        $res = $repos->Deletar($id);

        $_SESSION["message"] =
        '
        <div class="message-box success shown">
            <h4 class="message-title">Feito!</h4>
            <p class="message-body">Registro excluído com sucesso.</p>
        </div>
        ';
    } catch (Exception) {
        $sql = "SELECT g.nome, COUNT(*) 'qtd' FROM genero_jogo g JOIN produto p ON p.id_genero = g.id_genero WHERE g.id_genero = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        $res = $stmt->fetch();

        $_SESSION["message"] =
        '
        <div class="message-box fail shown">
            <h4 class="message-title">Erro!</h4>
            <p class="message-body">Não foi possível excluir este registro. <br> Detalhes: O genêro de jogo '. $res["nome"] .' possui '. $res["qtd"] .' jogos cadastrados.</p>
        </div>
        ';
    } finally {
        header("Location: consultar-genero.php");
        exit;
    }
}
