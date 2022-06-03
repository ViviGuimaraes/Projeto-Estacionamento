<?php
// __________________________________________________________________
//   Objetivo: Arquivo de funções que manipularão o BD
//   Autor: Vívian Guimarães Vaz
//   Data: 03/06/2022
//   Versão: 1.0
// ____________________________________________________________________
 

/**
 * 
 * @author Vívian Guimarães Vaz
 * @param String Status - retornar  o status da vaga : disponível, manutenção,ocupada, 
 * @return Bool se der retornará um buleano 
 */


// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');

//função para inserir o status da vaga
function insertStatusVaga($status){
    // abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Declaração de variável  para utilizar no return dessa função
    $resposta = (bool) false;

     // Script SQL para inserir os dados no BD
     $sql = "insert into tblStatusVaga (nome)
     values (

                '" . $status . "'
            );";


    //validação para veificar se o script SQL está correto
    if (mysqli_query($conexao, $sql)) {

        // Validação para verificar se uma linha foi afetada (acrescentada) no BD
        if (mysqli_affected_rows($conexao)){
            $resposta = true;
            }
    }

     // fechamento da conexão do banco
     fecharConexaoMySQL($conexao);
     return $resposta;
}

$status = '7';
//echo($nome);
insertStatusVaga($status);


?>