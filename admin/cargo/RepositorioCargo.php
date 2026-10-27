<?php

require_once __DIR__ . "/Cargo.php";

class RepositorioCargo
{
    public function __construct(private PDO $pdo) {}

    public function Consultar(int $id)
    {
        $sql = "SELECT * FROM cargo WHERE id_cargo = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch();
    }

    public function Cadastrar(Cargo $c)
    {
        $sql = "INSERT INTO cargo(status, nome, observacao, data_cadastro) VALUES(1, :n, :o, NOW())";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":n" => $c->nome,
            ":o" => $c->observacao
        ]);
    }

    public function Filtrar(array $filtros)
    {
        $sql = "SELECT * FROM cargo WHERE 1 = 1";
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

    public function Atualizar(Cargo $c) {
        $sql = "UPDATE cargo SET status = :s, nome = :n, observacao = :o WHERE id_cargo = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":s"  => $c->status,
            ":n"  => $c->nome,
            ":o"  => $c->observacao,
            ":id" => $c->id_cargo
        ]);
    }

    public function Deletar(int $id)
    {
        $sql = "DELETE FROM cargo WHERE id_cargo = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":id" => $id]);
    }
}
