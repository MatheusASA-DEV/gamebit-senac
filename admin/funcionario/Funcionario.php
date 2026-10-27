<?php

class Funcionario
{
    public function __construct(
        public int    $cargo,
        public string $nome,
        public string $nome_social,
        public string $data_nascimento,
        public string $sexo,
        public string $estado_civil,
        public string $cpf,
        public string $rg,
        public float  $salario,
        public string $endereco,
        public int    $numero,
        public string $complemento,
        public string $bairro,
        public string $cidade,
        public string $estado,
        public string $cep,
        public string $telefone_residencial,
        public string $telefone_celular,
        public string $email,
        public string $usuario,
        public string $senha,
        public int    $tipo_acesso,
        public string $foto = "",
        public int    $id = 0,
        public int    $status = 1,
        public string $data_cadastro = "NOW()"
    ) {}
}
