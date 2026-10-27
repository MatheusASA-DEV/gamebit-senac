<?php

// Verificando se existe um usuário logado e Administrador para permitir acesso a esta página
include_once __DIR__ . "/../UsuarioAdmin.php";

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../connection/connection.php";
require_once __DIR__ . "/Funcionario.php";
require_once __DIR__ . "/RepositorioFuncionario.php";

// Pega da URL o ID passado pelo filtrar-funcionario.php
$selectedIdFun = $_GET["id_func"] ?? null;

// Input Hidden
$insertRequest = $_POST["atualizar"] ?? null;

// Repositório de CRUD do funcionário
$repos = new RepositorioFuncionario($pdo);

if (isset($insertRequest) && $insertRequest == "true") {
    // Variáveis para armazenar o valor dos inputs para posteriormente inserir no banco
    $nome                 = $_POST["fun_nome"];
    $nome_social          = $_POST["fun_nome_social"];
    $sexo                 = $_POST["fun_sexo"];
    $cpf                  = $_POST["fun_cpf"];
    $rg                   = $_POST["fun_rg"];
    $estado_civil         = $_POST["fun_estado_civil"];
    $data_nascimento      = $_POST["fun_nascimento"];
    $email                = $_POST["fun_email"];
    $cargo                = $_POST["fun_cargo"];
    $cep                  = $_POST["fun_cep"];
    $cidade               = $_POST["fun_cidade"];
    $estado               = $_POST["fun_estado"];
    $endereco             = $_POST["fun_endereco"];
    $bairro               = $_POST["fun_bairro"];
    $numero               = $_POST["fun_numero"];
    $complemento          = $_POST["fun_complemento"];
    $telefone_celular     = $_POST["fun_telefone_celular"];
    $telefone_residencial = $_POST["fun_telefone_residencial"];
    $tipo_acesso          = $_POST["fun_acesso"];
    $usuario              = $_POST["fun_usuario"];
    $senha                = $_POST["fun_senha"];
    $salario              = $_POST["fun_salario"];
    $id                   = $_POST["fun_id"];
    $status               = $_POST["fun_status"];

    // $_FILES["htmlName"] retorna um objeto com os metadados do arquivo como:
    // [name] => minha_foto.jpg
    // [full_path] => minha_foto.jpg
    // [type] => image/jpeg
    // [tmp_name] => /tmp/phpYzdqkD
    // [error] => 0
    // [size] => 154203

    /** Acessamos a propriedade "name" do objeto */
    $foto = basename($_FILES["fun_foto"]["name"]);

    /** Acessamos a propriedade "tmp_name" do objeto (O servidor guarda temporariamente) */
    $temp = $_FILES["fun_foto"]["tmp_name"];

    /** Caminho do servidor que será guardada a foto para armazenar o arquivo mesmo */
    $finalPath = "../../images/funcionarios/" . $foto;

    /** Movemos o arquivo do temp para a pasta onde queremos, o name serve só para nome do arquivo mesmo */
    move_uploaded_file($temp, $finalPath);

    $funcionario = new Funcionario(
        $cargo,
        $nome,
        $nome_social,
        $data_nascimento,
        $sexo,
        $estado_civil,
        $cpf,
        $rg,
        $salario,
        $endereco,
        $numero,
        $complemento,
        $bairro,
        $cidade,
        $estado,
        $cep,
        $telefone_residencial,
        $telefone_celular,
        $email,
        $usuario,
        $senha,
        $tipo_acesso,
        $foto,
        $id,
        $status
    );

    try {
        $repos->Atualizar($funcionario);
        $_SESSION["message"] =
        '
        <div class="message-box success shown">
            <h4 class="message-title">Feito!</h4>
            <p class="message-body">Cadastro atualizado com sucesso.</p>
        </div>
        ';
    } catch (PDOException $e) {
        $_SESSION["message"] =
        '
        <div class="message-box fail shown">
            <h4 class="message-title">Erro!</h4>
            <p class="message-body">Não foi possível atualizar o cadastro. <br> Detalhes: ' . $e->getMessage() . '</p>
        </div>
        ';
    } finally {
        header("Location: consultar-funcionario.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Matheus de Andrade Silva Arruda">
    <title>GameBit | Painel Administrativo</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=JetBrains+Mono:ital,wght@0,100..800;1,100..800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.1/css/all.min.css"
        integrity="sha512-QeR2VH+lsBE5LSAe1Q5EnTBbe7XTBubt8dG93Y7gidSgdMCr8nVqKcfKAMyN96SV8KDbZVTDXChatu5G2KQGzg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- My Styles -->
    <link rel="stylesheet" href="../../custom/css/global.css">
    <link rel="stylesheet" href="../../custom/css/dashboard.css">
</head>

<body>
    <div id="dashboard-container">
        <?php include "../../components/DashboardSidebar.php" ?>

        <main>
            <?php require_once __DIR__ . "/../utils/message.php" ?>

            <section id="dashboard-content" class="dashboard-section">
                <div class="section-title-container">
                    <i class="fa-solid fa-address-card icon-section"></i>
                    <h2 class="section-title">Editar funcionários</h2>
                </div>

                <div class="form-container">
                    <?php

                    try {
                        $res = $repos->Consultar($selectedIdFun);
                    } catch (Exception $e) {
                        exit("Erro: " . $e->getMessage());
                    }

                    ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-section">
                            <h2 class="form-section-title">Dados Gerais</h2>

                            <div id="employee-photo-container">
                                <img src="<?= $finalURL ?>/images/funcionarios/<?= $res["foto"] ?>" alt="" id="employee-photo" class="showable-image" title="Imagem do funcionário">

                                <div id="photo-buttons-wrapper">
                                    <label id="photo-file-picker">
                                        Escolher arquivo...
                                        <input type="file" name="fun_foto" id="employee-picture" class="select-image-button" accept="image/*" style="display: none;">
                                    </label>

                                    <button type="button" id="clear-employee-picture" class="clear-image-button">Limpar seleção</button>
                                </div>
                            </div>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Status</p>

                                    <select name="fun_status" id="fun_status">
                                        <option value="1" class="form-option" <?= $res["status"] == 1 ? "selected" : "" ?>>Ativo</option>
                                        <option value="0" class="form-option" <?= $res["status"] == 0 ? "selected" : "" ?>>Inativo</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome</p>
                                    <input type="text" name="fun_nome" id="fun_nome" class="form-input" placeholder="Nome completo" value="<?= $res["nome"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome Social</p>
                                    <input type="text" name="fun_nome_social" id="fun_nome_social" class="form-input" placeholder="Nome social" value="<?= $res["nome_social"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Sexo</p>

                                    <select name="fun_sexo" id="fun_sexo">
                                        <option value="N" class="form-option" <?= $res["sexo"] == "N" ? "selected" : "" ?>>Não definido</option>

                                        <option value="M" class="form-option" <?= $res["sexo"] == "M" ? "selected" : "" ?>>Masculino</option>
                                        <option value="F" class="form-option" <?= $res["sexo"] == "F" ? "selected" : "" ?>>Feminino</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">CPF</p>
                                    <input type="text" name="fun_cpf" id="fun_cpf" class="form-input" placeholder="000.000.000-00" value="<?= $res["cpf"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">RG</p>
                                    <input type="text" name="fun_rg" id="fun_rg" class="form-input" placeholder="00.000.000-A" value="<?= $res["rg"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Estado Civil</p>
                                    <select name="fun_estado_civil" id="fun_estado_civil" required>
                                        <option value="Solteiro" class="form_option" <?= $res["estado_civil"] == "Solteiro" ? "selected" : "" ?>>Solteiro(a)</option>
                                        <option value="Casado" class="form_option" <?= $res["estado_civil"] == "Casado" ? "selected" : "" ?>>Casado(a)</option>
                                        <option value="União Estável" class="form_option" <?= $res["estado_civil"] == "União Estável" ? "selected" : "" ?>>União Estável</option>
                                        <option value="Viúvo" class="form_option" <?= $res["estado_civil"] == "Viúvo" ? "selected" : "" ?>>Viúvo(a)</option>
                                        <option value="Separado" class="form_option" <?= $res["estado_civil"] == "Separado" ? "selected" : "" ?>>Separado(a) Judicialmente</option>
                                        <option value="Divorciado" class="form_option" <?= $res["estado_civil"] == "Divorciado" ? "selected" : "" ?>>Divorciado(a)</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Data de Nascimento</p>
                                    <input type="date" name="fun_nascimento" id="fun_nascimento" class="form-input"
                                        placeholder="Nascimento" value="<?= $res["data_nascimento"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">E-mail</p>
                                    <input type="email" name="fun_email" id="fun_email" class="form-input"
                                        placeholder="E-mail" value="<?= $res["email"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Cargo</p>
                                    <select name="fun_cargo" id="fun_cargo" required>
                                        <?php

                                        $sql = "SELECT id_cargo, nome FROM cargo WHERE status = 1";

                                        try {
                                            $stmt = $pdo->prepare($sql);
                                            $stmt->execute();
                                            $cargos = $stmt->fetchAll();

                                            if (count($cargos) > 0) {
                                                foreach ($cargos as $cargo) {
                                                    echo '<option value="' . $cargo["id_cargo"] . '" class="form_option" ' . ($res["id_cargo"] == $cargo["id_cargo"] ? "selected" : "") . '>' . $cargo["nome"] . '</option>';
                                                }
                                            }
                                        } catch (PDOException $e) {
                                            exit("Erro ao popular select de cargos... " . $e->getMessage());
                                        }

                                        ?>

                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Endereço e Localização</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">CEP</p>
                                    <input type="text" name="fun_cep" id="cep" class="form-input" placeholder="CEP"
                                        data-mask="00000-000" value="<?= $res["cep"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Cidade</p>
                                    <input type="text" name="fun_cidade" id="cidade" class="form-input"
                                        placeholder="Cidade" value="<?= $res["cidade"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Estado</p>
                                    <select name="fun_estado" id="estado" required>
                                        <option value="AC" class="form_option" <?= $res["estado"] == "AC" ? "selected" : "" ?>>AC</option>
                                        <option value="AL" class="form_option" <?= $res["estado"] == "AL" ? "selected" : "" ?>>AL</option>
                                        <option value="AP" class="form_option" <?= $res["estado"] == "AP" ? "selected" : "" ?>>AP</option>
                                        <option value="AM" class="form_option" <?= $res["estado"] == "AM" ? "selected" : "" ?>>AM</option>
                                        <option value="BA" class="form_option" <?= $res["estado"] == "BA" ? "selected" : "" ?>>BA</option>
                                        <option value="CE" class="form_option" <?= $res["estado"] == "CE" ? "selected" : "" ?>>CE</option>
                                        <option value="DF" class="form_option" <?= $res["estado"] == "DF" ? "selected" : "" ?>>DF</option>
                                        <option value="ES" class="form_option" <?= $res["estado"] == "ES" ? "selected" : "" ?>>ES</option>
                                        <option value="GO" class="form_option" <?= $res["estado"] == "GO" ? "selected" : "" ?>>GO</option>
                                        <option value="MA" class="form_option" <?= $res["estado"] == "MA" ? "selected" : "" ?>>MA</option>
                                        <option value="MT" class="form_option" <?= $res["estado"] == "MT" ? "selected" : "" ?>>MT</option>
                                        <option value="MS" class="form_option" <?= $res["estado"] == "MS" ? "selected" : "" ?>>MS</option>
                                        <option value="MG" class="form_option" <?= $res["estado"] == "MG" ? "selected" : "" ?>>MG</option>
                                        <option value="PA" class="form_option" <?= $res["estado"] == "PA" ? "selected" : "" ?>>PA</option>
                                        <option value="PB" class="form_option" <?= $res["estado"] == "PB" ? "selected" : "" ?>>PB</option>
                                        <option value="PR" class="form_option" <?= $res["estado"] == "PR" ? "selected" : "" ?>>PR</option>
                                        <option value="PE" class="form_option" <?= $res["estado"] == "PE" ? "selected" : "" ?>>PE</option>
                                        <option value="PI" class="form_option" <?= $res["estado"] == "PI" ? "selected" : "" ?>>PI</option>
                                        <option value="RJ" class="form_option" <?= $res["estado"] == "RJ" ? "selected" : "" ?>>RJ</option>
                                        <option value="RN" class="form_option" <?= $res["estado"] == "RN" ? "selected" : "" ?>>RN</option>
                                        <option value="RS" class="form_option" <?= $res["estado"] == "RS" ? "selected" : "" ?>>RS</option>
                                        <option value="RO" class="form_option" <?= $res["estado"] == "RO" ? "selected" : "" ?>>RO</option>
                                        <option value="RR" class="form_option" <?= $res["estado"] == "RR" ? "selected" : "" ?>>RR</option>
                                        <option value="SC" class="form_option" <?= $res["estado"] == "SC" ? "selected" : "" ?>>SC</option>
                                        <option value="SP" class="form_option" <?= $res["estado"] == "SP" ? "selected" : "" ?>>SP</option>
                                        <option value="SE" class="form_option" <?= $res["estado"] == "SE" ? "selected" : "" ?>>SE</option>
                                        <option value="TO" class="form_option" <?= $res["estado"] == "TO" ? "selected" : "" ?>>TO</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Endereço</p>
                                    <input type="text" name="fun_endereco" id="endereco" class="form-input"
                                        placeholder="Endereço" value="<?= $res["endereco"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Bairro</p>
                                    <input type="text" name="fun_bairro" id="bairro" class="form-input"
                                        placeholder="Bairro" value="<?= $res["bairro"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Número</p>
                                    <input type="text" name="fun_numero" id="fun_numero" class="form-input"
                                        placeholder="Número" value="<?= $res["numero"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Complemento</p>
                                    <input type="text" name="fun_complemento" id="fun_complemento" class="form-input"
                                        placeholder="Complemento" value="<?= $res["complemento"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Telefone Celular</p>
                                    <input type="tel" name="fun_telefone_celular" id="fun_telefone_celular" class="form-input"
                                        placeholder="Telefone celular" data-mask="(00) 00000-0000" value="<?= $res["telefone_celular"] ?>">
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Telefone Residencial</p>
                                    <input type="tel" name="fun_telefone_residencial" id="fun_telefone_residencial" class="form-input"
                                        placeholder="Telefone residencial" data-mask="(00) 0000-0000" value="<?= $res["telefone_residencial"] ?>">
                                </label>

                            </div>
                        </div>

                        <div class="form-section">
                            <h2 class="form-section-title">Dados de Usuário</h2>

                            <div class="inputs-wrapper">
                                <label class="input-label">
                                    <p class="label-name">Tipo de acesso</p>
                                    <select name="fun_acesso" id="fun_acesso" required>
                                        <option value="0" class="form_option" <?= $res["tipo_acesso"] == 0 ? "selected" : "" ?>>Comum</option>
                                        <option value="1" class="form_option" <?= $res["tipo_acesso"] == 1 ? "selected" : "" ?>>Administrador</option>
                                    </select>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Nome de Usuário</p>
                                    <input type="text" name="fun_usuario" id="fun_usuario" class="form-input"
                                        placeholder="Nome de usuário" value="<?= $res["usuario"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Senha de Usuário</p>
                                    <input type="text" name="fun_senha" id="fun_usuario_senha" class="form-input"
                                        placeholder="Senha de usuário" autocomplete="off" value="<?= $res["senha"] ?>" required>
                                </label>

                                <label class="input-label">
                                    <p class="label-name">Salário</p>
                                    <input type="text" name="fun_salario" id="fun_salario" class="form-input"
                                        placeholder="Salário" data-mask="00000,00" data-mask-reverse="true" value="<?= $res["salario"] ?>" required>
                                </label>
                            </div>
                        </div>

                        <input type="hidden" name="atualizar" value="true">
                        
                        <!-- Input Hidden do ID recebido de filtrar-funcionario.php (URL) -->
                        <input type="hidden" name="fun_id" value="<?= $selectedIdFun ?>">

                        <button type="submit" class="default-button dashboard-button">Atualizar</button>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <!-- Script Dashboard -->
    <script src="../../custom/js/dashboard.js"></script>
    <script src="../../custom/js/message-box.js"></script>
    <script src="../../custom/js/photo-selection.js"></script>
    <script src="../../custom/js/via-cep.js"></script>
</body>

</html>