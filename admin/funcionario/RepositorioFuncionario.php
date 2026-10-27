<?php

require_once "./Funcionario.php";

class RepositorioFuncionario
{
    public function __construct(private PDO $pdo) {}

    public function Consultar(int $id)
    {
        $sql = "SELECT * FROM funcionario WHERE id_func = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        // fetch() usado quando vai retornar ou alterar apenas um registro do banco, pode retornar o registro ou bool
        $funcionario = $stmt->fetch();

        // Se falhar ou não encontrar nenhum registro, lança uma nova exception
        if (!$funcionario) throw new Exception("Este usuário não existe...");
        return $funcionario;
    }

    public function Cadastrar(Funcionario $f)
    {
        $sql = "INSERT INTO funcionario(
        id_func,
        id_cargo,
        nome,
        nome_social,
        foto,
        data_nascimento,
        sexo,
        estado_civil,
        cpf,
        rg,
        salario,
        endereco,
        numero,
        complemento,
        bairro,
        cidade,
        estado,
        cep,
        telefone_residencial,
        telefone_celular,
        email,
        usuario,
        senha,
        tipo_acesso,
        data_cadastro,
        status
      ) VALUES(
        :id,
        :cargo,
        :nome,
        :nome_social,
        :foto,
        :data_nascimento,
        :sexo,
        :estado_civil,
        :cpf,
        :rg,
        :salario,
        :endereco,
        :numero,
        :complemento,
        :bairro,
        :cidade,
        :estado,
        :cep,
        :telefone_residencial,
        :telefone_celular,
        :email,
        :usuario,
        :senha,
        :tipo_acesso,
        NOW(),
        1
      )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":id"                   => $f->id,
            ":cargo"                => $f->cargo,
            ":nome"                 => $f->nome,
            ":nome_social"          => $f->nome_social,
            ":foto"                 => $f->foto,
            ":data_nascimento"      => $f->data_nascimento,
            ":sexo"                 => $f->sexo,
            ":estado_civil"         => $f->estado_civil,
            ":cpf"                  => $f->cpf,
            ":rg"                   => $f->rg,
            ":salario"              => $f->salario,
            ":endereco"             => $f->endereco,
            ":numero"               => $f->numero,
            ":complemento"          => $f->complemento,
            ":bairro"               => $f->bairro,
            ":cidade"               => $f->cidade,
            ":estado"               => $f->estado,
            ":cep"                  => $f->cep,
            ":telefone_residencial" => $f->telefone_residencial,
            ":telefone_celular"     => $f->telefone_celular,
            ":email"                => $f->email,
            ":usuario"              => $f->usuario,
            ":senha"                => $f->senha,
            ":tipo_acesso"          => $f->tipo_acesso
        ]);
    }

    public function Filtrar(array $filtros)
    {
        $sql = "SELECT f.*, c.nome AS 'cargo' FROM funcionario f JOIN cargo c ON f.id_cargo = c.id_cargo WHERE 1 = 1";

        $params = [];

        // Verificando quais inputs de filtro foram inseridos algum valor
        if ($filtros["filter-status"] != null && $filtros["filter-status"] != "") {
            $sql .= " AND f.status = :status";
            $params[":status"] = $filtros["filter-status"];
        }

        if ($filtros["filter-sexo"] != null && $filtros["filter-sexo"] != "") {
            $sql .= " AND f.sexo = :sexo";
            $params[":sexo"] = $filtros["filter-sexo"];
        }

        if ($filtros["filter-nome"] != null && $filtros["filter-nome"] != "") {
            $sql .= " AND f.nome LIKE :nome";
            $params[":nome"] = "%" . $filtros["filter-nome"] . "%";
        }

        if ($filtros["filter-cargo"] != null && $filtros["filter-cargo"] != "") {
            $sql .= " AND f.id_cargo = :id_cargo";
            $params[":id_cargo"] = $filtros["filter-cargo"];
        }

        if ($filtros["filter-cidade"] != null && $filtros["filter-cidade"] != "") {
            $sql .= " AND f.cidade = :cidade";
            $params[":cidade"] = $filtros["filter-cidade"];
        }

        $sql .= " ORDER BY f.nome ASC";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function Atualizar(Funcionario $f)
    {
        $hasFoto = !empty($f->foto);

        $sql = "UPDATE funcionario SET
        id_cargo             = :cargo,
        nome                 = :nome,
        nome_social          = :nome_social,
        ". ($hasFoto ? "foto = :foto," : "") ."
        data_nascimento      = :data_nascimento,
        sexo                 = :sexo,
        estado_civil         = :estado_civil,
        cpf                  = :cpf,
        rg                   = :rg,
        salario              = :salario,
        endereco             = :endereco,
        numero               = :numero,
        complemento          = :complemento,
        bairro               = :bairro,
        cidade               = :cidade,
        estado               = :estado,
        cep                  = :cep,
        telefone_residencial = :telefone_residencial,
        telefone_celular     = :telefone_celular,
        email                = :email,
        usuario              = :usuario,
        senha                = :senha,
        tipo_acesso          = :tipo_acesso,
        status               = :status
        WHERE id_func = :id";

        $params = [
            ":status"               => $f->status,
            ":id"                   => $f->id,
            ":cargo"                => $f->cargo,
            ":nome"                 => $f->nome,
            ":nome_social"          => $f->nome_social,
            ":data_nascimento"      => $f->data_nascimento,
            ":sexo"                 => $f->sexo,
            ":estado_civil"         => $f->estado_civil,
            ":cpf"                  => $f->cpf,
            ":rg"                   => $f->rg,
            ":salario"              => $f->salario,
            ":endereco"             => $f->endereco,
            ":numero"               => $f->numero,
            ":complemento"          => $f->complemento,
            ":bairro"               => $f->bairro,
            ":cidade"               => $f->cidade,
            ":estado"               => $f->estado,
            ":cep"                  => $f->cep,
            ":telefone_residencial" => $f->telefone_residencial,
            ":telefone_celular"     => $f->telefone_celular,
            ":email"                => $f->email,
            ":usuario"              => $f->usuario,
            ":senha"                => $f->senha,
            ":tipo_acesso"          => $f->tipo_acesso
        ];

        if ($hasFoto) { $params[":foto"] = $f->foto; }

        return $this->pdo->prepare($sql)->execute($params);
        
    }

    public function Deletar(int $id)
    {
        $sql = "DELETE FROM funcionario WHERE id_func = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}
