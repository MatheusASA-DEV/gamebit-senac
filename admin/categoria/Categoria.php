<?php 

class Categoria {
    public function __construct(
        public string $nome,
        public int $status = 1,
        public int $id_categoria = 0,
        public string $data_cadastro = "NOW()"
    ) {}
}

?>