<?php
/*******************************************************************************************
 * Objetivo: Arquivo para criar a conexão com o banco de dados MySQL
 * Autor: Thales Santos
 * Data: 02/06/2022
 * Versão: 1.0
 ******************************************************************************************/

// Import do arquivo de configurações
require_once('../../module/config.php');

// Função que realiza a conexão com o MYSQL
function conexaoMySQL() {
    // Abrindo conexão
    $conexao = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    // Validando se a conexão foi bem sucedida
    if($conexao) 
        return $conexao;
    else 
        return false;
}

// Função que fecha a conexão com o banco de dados MySQL
function fecharConexaoMySQL($conexao) {
    mysqli_close($conexao);
}

?>