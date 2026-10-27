<?php

require_once __DIR__ . "/Produto.php";

class RepositorioProduto
{
    public function __construct(private PDO $pdo) {}

    public function ConsultarTudo(?int $limit = null, int $offset = 0)  {
        $sql = "SELECT p.*, pl.nome 'plataforma', m.nome 'marca', d.nome 'desenvolvedor', g.nome 'genero', c.id_categoria 'categoria' FROM produto p LEFT JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma LEFT JOIN marca m ON p.id_marca = m.id_marca LEFT JOIN desenvolvedor d ON p.id_desenvolvedor = d.id_desenvolvedor LEFT JOIN genero_jogo g ON p.id_genero = g.id_genero JOIN categoria c ON p.id_categoria = c.id_categoria WHERE p.status = 1";
        $param = [];

        if ($limit != null && $limit > 0) {
            $sql .= " LIMIT :offset, :limit";
            $param[":offset"] = $offset;
            $param[":limit"] = $limit;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($param);

        return $stmt->fetchAll();
    }

    public function ConsultarTudoNome(string $nome, ?int $limit = null, int $offset = 0) {
        $sql = "SELECT p.*, pl.nome 'plataforma', m.nome 'marca', d.nome 'desenvolvedor', g.nome 'genero', c.nome 'categoria' FROM produto p LEFT JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma LEFT JOIN marca m ON p.id_marca = m.id_marca LEFT JOIN desenvolvedor d ON p.id_desenvolvedor = d.id_desenvolvedor LEFT JOIN genero_jogo g ON p.id_genero = g.id_genero JOIN categoria c ON p.id_categoria = c.id_categoria WHERE p.nome LIKE :nome";
        $param = [];

        $param[":nome"] = "%" . $nome . "%";

        if ($limit != null && $limit > 0) {
            $sql .= " LIMIT :offset, :limit";
            $param[":offset"] = $offset;
            $param[":limit"] = $limit;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($param);

        return $stmt->fetchAll();
    }

    public function ConsultarRelacionadosCategoria(int $idCategoria, int $idProduto, ?int $limit = null, int $offset = 0)
    {
        $sql = "SELECT p.*, pl.nome 'plataforma', m.nome 'marca', d.nome 'desenvolvedor', g.nome 'genero', c.id_categoria 'categoria' FROM produto p LEFT JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma LEFT JOIN marca m ON p.id_marca = m.id_marca LEFT JOIN desenvolvedor d ON p.id_desenvolvedor = d.id_desenvolvedor LEFT JOIN genero_jogo g ON p.id_genero = g.id_genero JOIN categoria c ON p.id_categoria = c.id_categoria WHERE p.id_categoria = :id_categoria AND p.id_produto != :id_produto";
        $param = [];

        $param[":id_categoria"] = $idCategoria;
        $param[":id_produto"] = $idProduto;

        $sql .= " ORDER BY RAND()";

        if ($limit != null && $limit > 0) {
            $sql .= " LIMIT :offset, :limit";
            $param[":offset"] = $offset;
            $param[":limit"] = $limit;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($param);

        return $stmt->fetchAll();
    }

    public function Consultar(int $id)
    {
        $sql = "SELECT p.*, pl.nome 'plataforma', m.nome 'marca', d.nome 'desenvolvedor', g.nome 'genero', c.nome 'categoria' FROM produto p LEFT JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma LEFT JOIN marca m ON p.id_marca = m.id_marca LEFT JOIN desenvolvedor d ON p.id_desenvolvedor = d.id_desenvolvedor LEFT JOIN genero_jogo g ON p.id_genero = g.id_genero JOIN categoria c ON p.id_categoria = c.id_categoria WHERE id_produto = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        return $stmt->fetch();
    }

    public function ConsultarJogos(?int $limit = null, int $offset = 0)
    {
        $sql = "SELECT p.*, pl.nome 'plataforma', m.nome 'marca', d.nome 'desenvolvedor', g.nome 'genero', c.id_categoria 'categoria' FROM produto p LEFT JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma LEFT JOIN marca m ON p.id_marca = m.id_marca LEFT JOIN desenvolvedor d ON p.id_desenvolvedor = d.id_desenvolvedor LEFT JOIN genero_jogo g ON p.id_genero = g.id_genero JOIN categoria c ON p.id_categoria = c.id_categoria WHERE p.status = 1 AND c.nome = 'Jogos'";
        $param = [];

        $sql .= " ORDER BY RAND()";

        if ($limit != null && $limit > 0) {
            $sql .= " LIMIT :offset, :limit";
            $param[":offset"] = $offset;
            $param[":limit"] = $limit;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($param);

        return $stmt->fetchAll();
    }

    public function ConsultarConsoles(?int $limit = null, int $offset = 0)
    {
        $sql = "SELECT p.*, pl.nome 'plataforma', m.nome 'marca', d.nome 'desenvolvedor', g.nome 'genero', c.id_categoria 'categoria' FROM produto p LEFT JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma LEFT JOIN marca m ON p.id_marca = m.id_marca LEFT JOIN desenvolvedor d ON p.id_desenvolvedor = d.id_desenvolvedor LEFT JOIN genero_jogo g ON p.id_genero = g.id_genero JOIN categoria c ON p.id_categoria = c.id_categoria WHERE p.status = 1 AND c.nome = 'Consoles'";
        $param = [];

        $sql .= " ORDER BY RAND()";

        if ($limit != null && $limit > 0) {
            $sql .= " LIMIT :offset, :limit";
            $param[":offset"] = $offset;
            $param[":limit"] = $limit;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($param);

        return $stmt->fetchAll();
    }

    public function Cadastrar(Produto $p)
    {
        $sql = "INSERT INTO produto(id_desenvolvedor, id_plataforma, id_genero, id_categoria, id_marca, nome, estoque, cpu_min, gpu_min, so_min, ram_min, preco_custo, lucro, preco_venda, status_promocao, desconto, preco_promocao, descricao, imagem_principal, imagem_2, imagem_3, imagem_4, armazenamento, leitor, voltagem, cor, status, data_cadastro) VALUES(:id_desenvolvedor, :id_plataforma, :id_genero, :id_categoria, :id_marca, :nome, :estoque, :cpu, :gpu, :so, :ram, :custo, :lucro, :venda, :status_promocao, :desconto, :preco_promocao, :descricao, :imagem_principal, :imagem2, :imagem3, :imagem4, :armazenamento, :leitor, :voltagem, :cor, 1, NOW())";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":id_desenvolvedor" => $p->id_desenvolvedor,
            ":id_plataforma" => $p->id_plataforma,
            ":id_genero" => $p->id_genero,
            ":id_categoria" => $p->id_categoria,
            ":id_marca" => $p->id_marca,
            ":nome" => $p->nome,
            ":estoque" => $p->estoque,
            ":cpu" => $p->cpu_min,
            ":gpu" => $p->gpu_min,
            ":so" => $p->so_min,
            ":ram" => $p->ram_min,
            ":custo" => $p->preco_custo,
            ":lucro" => $p->lucro,
            ":venda" => $p->preco_venda,
            ":status_promocao" => $p->status_promocao,
            ":desconto" => $p->desconto,
            ":preco_promocao" => $p->preco_promocao, 
            ":descricao" => $p->descricao,
            ":imagem_principal" => $p->imagem_principal,
            ":imagem2" => $p->imagem_2,
            ":imagem3" => $p->imagem_3,
            ":imagem4" => $p->imagem_4,
            ":armazenamento" => $p->armazenamento,
            ":leitor" => $p->leitor,
            ":voltagem" => $p->voltagem,
            ":cor" => $p->cor
        ]);
    }

    public function Filtrar(array $filtros)
    {
        $sql = "SELECT p.*, c.nome 'categoria', m.nome 'marca', pl.nome 'plataforma', g.nome 'genero', d.nome 'desenvolvedor' FROM produto p JOIN categoria c ON p.id_categoria = c.id_categoria LEFT JOIN marca m ON p.id_marca = m.id_marca LEFT JOIN plataforma pl ON p.id_plataforma = pl.id_plataforma LEFT JOIN genero_jogo g ON p.id_genero = g.id_genero LEFT JOIN desenvolvedor d ON p.id_desenvolvedor = d.id_desenvolvedor WHERE 1 = 1";
        $params = [];

        if ($filtros["filter-status"] != null && $filtros["filter-status"] != "") {
            $sql .= " AND p.status = :s";
            $params[":s"] = $filtros["filter-status"];
        }

        if ($filtros["filter-nome"] != null && $filtros["filter-nome"] != "") {
            $sql .= " AND p.nome LIKE :n";
            $params[":n"] = "%" . $filtros["filter-nome"] . "%";
        }

        if ($filtros["filter-categoria"] != null && $filtros["filter-categoria"] != "") {
            $sql .= " AND p.id_categoria = :id_categoria";
            $params[":id_categoria"] = $filtros["filter-categoria"];
        }

        if ($filtros["filter-desenvolvedor"] != null && $filtros["filter-desenvolvedor"] != "") {
            $sql .= " AND p.id_desenvolvedor = :id_desenvolvedor";
            $params[":id_desenvolvedor"] = $filtros["filter-desenvolvedor"];
        }

        if ($filtros["filter-marca"] != null && $filtros["filter-marca"] != "") {
            $sql .= " AND p.id_marca = :id_marca";
            $params[":id_marca"] = $filtros["filter-marca"];
        }

        if ($filtros["filter-estoque-min"] != null && $filtros["filter-estoque-min"] != "" && $filtros["filter-estoque-max"] != null && $filtros["filter-estoque-max"] != "") {
            $sql .= " AND p.estoque BETWEEN :min AND :max";
            $params[":min"] = $filtros["filter-estoque-min"];
            $params[":max"] = $filtros["filter-estoque-max"];
        }

        $sql .= " ORDER BY p.nome ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    public function Atualizar(Produto $p)
    {
        $principal = !empty($p->imagem_principal);
        $i2 = !empty($p->imagem_2);
        $i3 = !empty($p->imagem_3);
        $i4 = !empty($p->imagem_4);
        
        $sql = "UPDATE produto SET id_desenvolvedor = :id_desenvolvedor, id_plataforma =  :id_plataforma, id_genero = :id_genero, id_categoria = :id_categoria, id_marca = :id_marca, nome = :nome, estoque = :estoque, cpu_min = :cpu, gpu_min = :gpu, so_min = :so, ram_min = :ram, preco_custo = :custo, lucro = :lucro, preco_venda = :venda, status_promocao = :status_promocao, desconto = :desconto, preco_promocao = :preco_promocao, descricao = :descricao, ". ($principal ? "imagem_principal = :imagem_principal," : "")  ." ". ($i2 ? "imagem_2 = :imagem_2," : "")  ." ". ($i3 ? "imagem_3 = :imagem_3," : "")  ." ". ($i4 ? "imagem_4 = :imagem_4," : "")  ." armazenamento = :armazenamento, leitor = :leitor, voltagem = :voltagem, cor = :cor, status = :status WHERE id_produto = :id";

        $params = [
            ":id_desenvolvedor" => $p->id_desenvolvedor,
            ":id_plataforma" => $p->id_plataforma,
            ":id_genero" => $p->id_genero,
            ":id_categoria" => $p->id_categoria,
            ":id_marca" => $p->id_marca,
            ":nome" => $p->nome,
            ":estoque" => $p->estoque,
            ":cpu" => $p->cpu_min,
            ":gpu" => $p->gpu_min,
            ":so" => $p->so_min,
            ":ram" => $p->ram_min,
            ":custo" => $p->preco_custo,
            ":lucro" => $p->lucro,
            ":venda" => $p->preco_venda,
            ":status_promocao" => $p->status_promocao,
            ":desconto" => $p->desconto,
            ":preco_promocao" => $p->preco_promocao, 
            ":descricao" => $p->descricao
        ];

        if ($principal) { $params[":imagem_principal"] = $p->imagem_principal; };
        if ($i2) { $params[":imagem_2"] = $p->imagem_2; };
        if ($i3) { $params[":imagem_3"] = $p->imagem_3; };
        if ($i4) { $params[":imagem_4"] = $p->imagem_4; };

        $params[":armazenamento"] = $p->armazenamento;
        $params[":leitor"] = $p->leitor;
        $params[":voltagem"] = $p->voltagem;
        $params[":cor"] = $p->cor;
        $params[":status"] = $p->status;
        $params[":id"] = $p->id_produto;

        return $this->pdo->prepare($sql)->execute($params);
    }

    public function Deletar(int $id)
    {
        $sql = "DELETE FROM produto WHERE id_produto = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([":id" => $id]);
    }



    public function ChartDataEstoque()
    {
        $sql = "SELECT nome, estoque FROM produto WHERE status = 1 AND estoque <= 30 LIMIT 5";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}