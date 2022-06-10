<?php
// ______________________________________________________________
// Objetivo: Arquivo responsável pela manipulação de dados de contatos
//            Obs(Este arquivo fará ponte entre a VIEW e a MODEL)
// Autor: Vívian Guimaães Vaz
//Data: 10/006/2022
//versão: 1.0
//________________________________________________________________________

//inportação do arquivo de configuração do projeto 
require_once('../module/config.php');

//inporte do arqquivo de modelagem do Setor
require_once(SRC.'model/bd/setor.php');



//   Função responsável por tratar os dados para inserção do nome do Setor
//   @author Vívian Guimaraes Vaz
//   @param Array $dados Informações do  Setor - nome, ativo e idPiso
//   @return Bool True se foi inserido, se não Array com uma mensagem de erro
function inserirSetor($dados){

    //validação para verificar se há conteúdo para inserção do Setor 
    if(!empty($dados)){

        // Validação para verificar se o campo obrigatório 'Nome', 'idPiso', 'Ativo' foi informado
        if(!empty($dados['nome']) && !empty($dados['ativo']) && !empty($dados['idPiso']) ){

             // Validação para verificar se o ID do setor é válido
             if(is_numeric($dados['idPiso']) && $dados['idPiso'] > 0) {

                // Chamando a model e passando os dados 
                if(insertSetor($dados))
                    return true;
                else
                    return MESSAGES['error']['Insert'][0];
             }else
                 return MESSAGES['error']['IDs'][0];
        }else 
            return MESSAGES['error']['Data'][1];
    }else
      return MESSAGES['error']['Data'][0];    
}

//print_r(inserirSetor($dados));









?>