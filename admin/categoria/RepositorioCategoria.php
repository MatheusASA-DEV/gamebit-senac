<?php

require_once __DIR__ . "/Categoria.php";

class RepositorioCategoria
{
    public function __construct(private PDO $pdo) {}

    public function Consultar(int $id)
    {
        $sql = "SELECT * FROM categoria WHERE id_categoria = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch();
    }

    public function Cadastrar(Categoria $c)
    {
        $sql = "INSERT INTO categoria(status, nome, data_cadastro) VALUES(1, :n, NOW())";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":n" => $c->nome]);
    }

    public function Filtrar(array $filtros)
    {
        $sql = "SELECT * FROM categoria WHERE 1 = 1";
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

    public function Atualizar(Categoria $c)
    {
        $sql = "UPDATE categoria SET status = :s, nome = :n WHERE id_categoria = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":s"  => $c->status,
            ":n"  => $c->nome,
            ":id" => $c->id_categoria
        ]);
    }

    public function Deletar(int $id)
    {
        $sql = "DELETE FROM categoria WHERE id_categoria = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":id" => $id]);
    }
}
