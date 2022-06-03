<?php
// __________________________________________________________________
//   Objetivo: Arquivo de funções que manipularão o BD
//   Autor: Vívian Guimarães Vaz
//   Data: 02/06/2022
//   Versão: 1.0
// ____________________________________________________________________
 
// Import do arquivo responsável pela Conexão do BD 
require_once('conexaoMySQL.php');


/**
 * 
 * @author Vívian Guimarães Vaz
 * @param String nome - retornar qual o tipo de veículo ex: carro, moto, vam
 * @return Bool se der retornará um buleano 
 */


 // função para inserir o tipo de veiculo 
function insertTipoVeiculo($nome){

    // abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Declaração de variável  para utilizar no return dessa função
    $resposta = (bool) false;

     // Script SQL para inserir os dadso no BD
     $sql = "insert into tblTipoVeiculo (nome)
     values (

                '" . $nome . "'
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


$nome = 'van';

insertTipoVeiculo($nome);





?>