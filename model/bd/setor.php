<?php
// __________________________________________________________________
//   Objetivo: Arquivo de funções que manipularão o BD
//   Autor: Vívian Guimarães Vaz
//   Data: 02/06/2022
//   Versão: 1.0
// ____________________________________________________________________

//Import do arquivo responsável 
require_once('conexaoMySQL.php');

//função para inserir o nome do setor
function  insertSetor($dados){


    //abrindo conexão com o BD
    $conexao = conexaoMySQL();

     //declaração de variável para ultilizar no return desta função 
     $resposta = (bool) false;

     // Script SQL para inserir os dados no BD

     $sql = "

            INSERT INTO tblSetor (nome, idPiso)
                values (
                            '".$dados['nome']."',
                            {$dados['idPiso']}
                    
                    )
     ";


      //validação para verificar se o SCRIPT está correto 
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

$dados = array(  
    "nome" => "uva",
    "idPiso" => 4
);
         
        insertSetor($dados);

        var_dump($dados);




?>