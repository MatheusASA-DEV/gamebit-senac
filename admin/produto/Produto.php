<?php 

class Produto
{
    public function __construct(
        public string $nome,
        public int $estoque,
        public float $preco_custo,
        public float $lucro,
        public float $preco_venda,
        public string $imagem_principal,
        public int $id_categoria,
        
        public ?int $status_promocao,
        public ?float $desconto,
        public ?string $cpu_min,
        public ?string $gpu_min,
        public ?string $ram_min,
        public ?string $so_min,
        public ?string $descricao,
        public ?float $preco_promocao,
        public ?string $imagem_2,
        public ?string $imagem_3,
        public ?string $imagem_4,
        public ?string $cor,
        public ?string $armazenamento,
        public ?int $leitor,
        public ?string $voltagem,
        public ?int $id_desenvolvedor = 0,
        public ?int $id_plataforma = 0,
        public ?int $id_genero = 0,
        public ?int $id_marca = 0,
        public ?int $status = 1,
        public ?int $id_produto = 0,
        public ?string $data_cadastro = "NOW()"
    ) {}
}

?>