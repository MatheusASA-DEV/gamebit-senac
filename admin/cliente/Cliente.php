<?php 

class Cliente
{
    public function __construct(
        public string $nome,
        public string $rg,
        public string $cpf,
        public string $endereco,
        public string $complemento,
        public string $cidade,
        public string $cep,
        public int $numero,
        public string $bairro,
        public string $estado,
        public string $email,
        public string $senha,
        public string $telefone,
        public string $celular,
        public string $sexo,
        public string $data_nascimento,
        public string $estado_civil,
        public int $id_cliente = 0,
        public int $status = 1,
        public string $data_cadastro = "NOW()"
    ) {}
}

?>