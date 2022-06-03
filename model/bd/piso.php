<?php
// __________________________________________________________________
//   Objetivo: Arquivo de funções que manipularão o BD
//   Autor: Vívian Guimarães Vaz
//   Data: 02/06/2022
//   Versão: 1.0
// ____________________________________________________________________

//Import do arquivo responsável 
require_once('conexaoMySQL.php');

/**
 * 
 * @author Vívian Guimarães Vaz
 * @param String nome - retornar o nome do piso :piso1, piso2, piso3
 * @return Bool se der retornará um buleano 
 */

 //função para inserir o nome do piso
 function insertPiso($nome){

    //abrir conexão com o BD
    $conexao = conexaoMySQL();

    //declaração de variável para ultilizar no return desta função 
    $resposta = (bool) false;

    // Script SQL para inserir os dados no BD
    $sql = "insert into tblPiso (nome)
    values (

               '" . $nome . "'
           );";

    //valiação para verificar se o script MSQL está correto
    if(mysqli_query($conexao,$sql)){

        //validação para verificar se a linha foi acrscentada o BD
        if(mysqli_affected_rows($conexao)){
            $resposta = true;
        }
    }

    //fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        return $resposta;
 }

        $nome = '12';
         
        insertPiso($nome);

        echo($nome);



 ?>