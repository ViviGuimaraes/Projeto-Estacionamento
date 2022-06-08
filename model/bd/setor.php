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
 * função para inserir o nome do setor
 * 
 * @author Vívian Guimarães Vaz
 * @param String  nome do Setor :SetorA, setorB, 
 * @return Bool se der retornará um buleano 
 */
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

          //validação para verificar se a linha foi acrescentada o BD
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
         
        // insertSetor($dados);
        // //var_dump($dados);


/**
 *  //função para deletar o nome do Setor
 * 
 * @author Vívian Guimarães Vaz
 * @param String  nome do piso :piso1, piso2, piso3
 * @return Bool se der retornará um buleano 
 */
function deleteSetor($id){

     //abrir conexão com o banco 
     $conexao = conexaoMySQL();

     //variável de ambiente
    $resposta = (bool) false;

    //Script SQL para excluir o nome do Setor
    $sql = " delete from tblSetor
                where id = {$id}";
        
    //validação para verificar se o script está correto
    if(mysqli_query($conexao,$sql)){

        //validação para verificar se o script foi apagado 
        if(mysqli_affected_rows($conexao))
        $resposta =true;
    }

    //encerrando a conexão com o banco 
    fecharConexaoMySQL($conexao);
    return $resposta;
}
// var_dump(deleteSetor(55));


/**
 *  função para para fazer o update dos dados através do id
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */
function updateSetor($dados){

    //abrindo conexão com o BD
    $conexao = conexaoMySQL();

    //variável de ambiente para retornar dados para a função
    $resposta =(bool) false;

    //script SQL para inserir os dados no BD
    $sql = "
            update tblSetor set
            
            nome = '{$dados['nome']}',
            idPiso = {$dados['id']}
            where id ={$dados['id']}
            
            ";


    //validção para verificar se o script está correto
    if(mysqli_query($conexao,$sql)){

        //validação paara verificar se a linha foi alterada
        if(mysqli_affected_rows($conexao))
            $resposta = true;
    }

    //solicitação para o fehcamento da conexão com o BD
    fecharConexaoMySQL($conexao);
    return $resposta;
}

// $dados= array(
//     "nome"   => "b3",
//     "id"     => 10,
//     "idPiso" => 4
 
// );

// echo '<pre>';
// echo json_encode(updateSetor($dados));
// echo '</pre>';
// die;



/**
 *  função para listar dados 
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */ 
function selectAllSetor(){

    // abrindo conexão com o BD
    $conexao = conexaoMySQL();


    // Script SQL para listar todos os Corredores
    $sql = "SELECT 
                tblSetor.id,
                tblSetor.nome AS codigo,
                tblSetor.ativo AS status,
                
                tblPiso.nome AS piso,
                tblSetor.nome AS setor
                
                FROM tblSetor
                    INNER JOIN tblPiso 
                        ON tblSetor.idPiso = tblPiso.id";

        
    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno do BD
    if($resposta) {
        // Convertendo os dados obtidos em Array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado
            $arrayDados[$contador] = array(
                "id"        => $resultado['id'],
                "codigo"    => $resultado['codigo'],
                "status"    => $resultado['status'],

                "localizacao" => array(
                    "piso" => $resultado['piso']    
                )
            );

            $contador++;
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;

}
//echo json_encode(selectAllSetor());



/**
 *  função para listar dados por id 
 * 
 * @author Vívian Guimarães Vaz
 * @param void
 * @return bool se der retornará um buleano 
 */ 
function selectByIdSetor($id) {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os setores
    $sql = "SELECT 
                tblSetor.id,
                tblSetor.nome AS codigo,
                tblSetor.ativo AS status,
                
                tblPiso.nome AS piso,
                tblSetor.nome AS setor
                
                FROM tblSetor
                    INNER JOIN tblPiso 
                        ON tblSetor.idPiso = tblPiso.id
            WHERE tblSetor.id = {$id}";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno do BD
    if($resposta) {
        // Convertendo os dados obtidos em Array
        if($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado
            $arrayDados = array(
                "id"        => $resultado['id'],
                "codigo"    => $resultado['codigo'],
                "status"    => $resultado['status'] ,

                "localizacao" => array(
                    "piso" => $resultado['piso']
                )
            );
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;    
}

// echo json_encode(selectAllSetor());





function selectAllSetorAtivated() {
    // Abrindo conexão com o BD
    $conexao = conexaoMySQL();

    // Script SQL para listar todos os Corredores
    $sql = "SELECT 
                tblSetor.id,
                tblSetor.nome AS codigo,
                tblSetor.ativo AS status,
                
                tblPiso.nome AS piso,
                tblSetor.nome AS setor
                
                FROM tblSetor
                    
                    INNER JOIN tblPiso 
                        ON tblSetor.idPiso = tblPiso.id
            WHERE tblSetor.ativo = 1";

    $resposta = mysqli_query($conexao, $sql);

    // Validação para verificar se houve retorno do BD
    if($resposta) {
        // Convertendo os dados obtidos em Array
        $contador = 0;
        while($resultado = mysqli_fetch_assoc($resposta)) {
            // Montando um array personalizado
            $arrayDados[$contador] = array(
                "id"        => $resultado['id'],
                "codigo"    => $resultado['codigo'],
                "status"    => $resultado['status'],

                "localizacao" => array(
                    "piso" => $resultado['piso']
                )
            );

            $contador++;
        }

    }

    // Solitando o fechamento da conexão com o BD
    fecharConexaoMySQL($conexao);
        
    // Retornando os dados encontrados ou false
    return isset($arrayDados) ? $arrayDados : false;
}



?>