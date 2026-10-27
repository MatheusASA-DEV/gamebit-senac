<?php

require_once __DIR__ . "/GeneroJogo.php";

class RepositorioGeneroJogo
{
    public function __construct(private PDO $pdo) {}

    public function Consultar(int $id)
    {
        $sql = "SELECT * FROM genero_jogo WHERE id_genero = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch();
    }

    public function Cadastrar(GeneroJogo $g)
    {
        $sql = "INSERT INTO genero_jogo(status, nome, data_cadastro) VALUES(1, :n, NOW())";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":n" => $g->nome]);
    }

    public function Filtrar(array $filtros)
    {
        $sql = "SELECT * FROM genero_jogo WHERE 1 = 1";
        $params = [];

        if ($filtros["filter-status"] != null && $filtros["filter-status"] != "") {
            $sql .= " AND status = :s";
            $params[":s"] = $filtros["filter-status"];
        }

        if ($filtros["filter-nome"] != null && $filtros["filter-nome"] != "") {
            $sql .= " AND nome LIKE :n";
            $params[":n"] = "%" . $filtros["filter-nome"] . "%";
        }

        $sql .= " ORDER BY nome ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function Atualizar(GeneroJogo $g)
    {
        $sql = "UPDATE genero_jogo SET status = :s, nome = :n WHERE id_genero = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":s"  => $g->status,
            ":n"  => $g->nome,
            ":id" => $g->id_genero
        ]);
    }

    public function Deletar(int $id)
    {
        $sql = "DELETE FROM genero_jogo WHERE id_genero = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":id" => $id]);
    }
}
