<?php

require_once __DIR__ . "/Cliente.php";

class RepositorioCliente
{
    public function __construct(private PDO $pdo) {}

    public function Consultar(int $id)
    {
        $sql = "SELECT * FROM cliente WHERE id_cliente = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch();
    }

    public function Cadastrar(Cliente $c)
    {
        $sql = "INSERT INTO cliente(nome, rg, cpf, endereco, complemento, cidade, cep, numero, bairro, estado, email, senha, telefone_residencial, telefone_celular, sexo, estado_civil, data_nascimento, status, data_cadastro) VALUES(:nome, :rg, :cpf, :endereco, :complemento, :cidade, :cep, :numero, :bairro, :estado, :email, :senha, :res, :cel, :sexo, :civil, :nascimento, 1, NOW())";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ":nome" => $c->nome,
            ":rg" => $c->rg,
            ":cpf" => $c->cpf,
            ":endereco" => $c->endereco,
            ":complemento" => $c->complemento,
            ":cidade" => $c->cidade,
            ":cep" => $c->cidade,
            ":numero" => $c->numero,
            ":bairro" => $c->bairro,
            ":estado" => $c->estado,
            ":email" => $c->email,
            ":senha" => $c->senha,
            ":res" => $c->telefone,
            ":cel" => $c->celular,
            ":sexo" => $c->sexo,
            ":civil" => $c->estado_civil,
            ":nascimento" => $c->data_nascimento
        ]);
    }

    public function Filtrar(array $filtros)
    {
        $sql = "SELECT * FROM cliente WHERE 1 = 1";
        $params = [];

        if ($filtros["filter-status"] != null && $filtros["filter-status"] != "") {
            $sql .= " AND status = :s";
            $params[":s"] = $filtros["filter-status"];
        }

        if ($filtros["filter-nome"] != null && $filtros["filter-nome"] != "") {
            $sql .= " AND nome LIKE :n";
            $params[":n"] = "%" . $filtros["filter-nome"] . "%";
        }

        if ($filtros["filter-sexo"] != null && $filtros["filter-sexo"] != "") {
            $sql .= " AND sexo = :sexo";
            $params[":sexo"] = $filtros["filter-sexo"];
        }

        if ($filtros["filter-cidade"] != null && $filtros["filter-cidade"] != "") {
            $sql .= " AND cidade = :cidade";
            $params[":cidade"] = $filtros["filter-cidade"];
        }

        // Adicionar filtro de intervalo de data cadastro

        $sql .= " ORDER BY nome ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function Atualizar(Cliente $c)
    {
        $sql = "UPDATE cliente SET nome = :nome, rg = :rg, cpf = :cpf, status = :status, endereco = :endereco, complemento = :complemento, cidade = :cidade, cep = :cep, numero = :num, bairro = :bairro, estado = :estado, email = :email, senha = :senha, telefone_residencial = :res, telefone_celular = :cel, sexo = :sexo, data_nascimento = :nasc, estado_civil = :civil WHERE id_cliente = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ":nome" => $c->nome,
            ":rg" => $c->rg,
            ":cpf" => $c->cpf,
            ":status" => $c->status,
            ":endereco" => $c->endereco,
            ":complemento" => $c->complemento,
            ":cidade" => $c->cidade,
            ":cep" => $c->cep,
            ":num" => $c->numero,
            ":bairro" => $c->bairro,
            ":estado" => $c->estado,
            ":email" => $c->email,
            ":senha" => $c->senha,
            ":res" => $c->telefone,
            ":cel" => $c->celular,
            ":sexo" => $c->sexo,
            ":nasc" => $c->data_nascimento,
            ":civil" => $c->estado_civil,
            ":id" => $c->id_cliente
        ]);
    }

    public function Deletar(int $id)
    {
        $sql = "DELETE FROM cliente WHERE id_cliente = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":id" => $id]);
    }
}