<?php

require_once __DIR__ . "/Marca.php";

class RepositorioMarca
{
    public function __construct(private PDO $pdo) {}

    public function Consultar(int $id)
    {
        $sql = "SELECT * FROM marca WHERE id_marca = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch();
    }

    public function Cadastrar(Marca $m)
    {
        $sql = "INSERT INTO marca(status, nome, data_cadastro) VALUES(1, :n, NOW())";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":n" => $m->nome]);
    }

    public function Filtrar(array $filtros)
    {
        $sql = "SELECT * FROM marca WHERE 1 = 1";
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

    public function Atualizar(Marca $m)
    {
        $sql = "UPDATE marca SET status = :s, nome = :n WHERE id_marca = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":s"  => $m->status,
            ":n"  => $m->nome,
            ":id" => $m->id_marca
        ]);
    }

    public function Deletar(int $id)
    {
        $sql = "DELETE FROM marca WHERE id_marca = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":id" => $id]);
    }
}
