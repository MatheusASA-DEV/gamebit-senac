<?php 

require_once __DIR__ . "/../../connection/connection.php";

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input["image"]) && isset($input["column"])) {
    $col = $input["column"];
    $img = $input["image"];

    $colunasPermitidas = ["imagem_principal", "imagem_2", "imagem_3", "imagem_4"];
    
    if (!in_array($col, $colunasPermitidas)) {
        http_response_code(400);
        exit;
    }

    $sql = "UPDATE produto SET {$col} = NULL WHERE {$col} = ?";
    
    try {
        $stmt = $pdo->prepare($sql);
        $res = $stmt->execute([$img]);

        if ($res) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }
    }
    catch (PDOException $e) {
        http_response_code(400);
    }
} else {
    http_response_code(400);
}
?>