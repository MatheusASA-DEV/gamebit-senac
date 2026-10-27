<?php 

$partialURL = $_SERVER["REQUEST_URI"]; /** Retorna o caminho relativo após o host */
$splitURL = explode("/", $partialURL); /** Array splitado da URL após o host | Índice 0 = o que vem antes da / barra  */
$finalURL = "http://" . $_SERVER["HTTP_HOST"] . "/" . $splitURL[1] . "/" . $splitURL[2]; /** http://localhost/projeto/Gamebit/ */

?>