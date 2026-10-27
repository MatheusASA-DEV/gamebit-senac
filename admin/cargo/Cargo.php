<?php 

class Cargo {
    public function __construct(
        public string $nome,
        public string $observacao,
        public int $id_cargo = 0,
        public int $status = 1,
        public string $data_cadastro = "NOW()"
    ) {}
}

?>