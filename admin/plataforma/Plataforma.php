<?php 

class Plataforma {
    public function __construct(
        public string $nome,
        public int $status = 1,
        public int $id_plataforma = 0,
        public string $data_cadastro = "NOW()"
    ) {}
}

?>