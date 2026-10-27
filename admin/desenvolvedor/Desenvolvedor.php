<?php

class Desenvolvedor
{
    public function __construct(
        public string $nome,
        public int $status = 1,
        public int $id_desenvolvedor = 0,
        public string $data_cadastro = "NOW()"
    ) {}
}
