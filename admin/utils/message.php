<?php 

// Se receber algum valor, exibe e já mata
if (isset($_SESSION["message"])) {
    echo $_SESSION["message"];
    unset($_SESSION["message"]);
}

?>