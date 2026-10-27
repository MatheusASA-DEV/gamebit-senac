<?php 

class GeneroJogo {
    public function __construct(
        public string $nome,
        public int $status = 1,
        public int $id_genero = 0,
        public string $data_cadastro = "NOW()"
    ) {}
}

?>