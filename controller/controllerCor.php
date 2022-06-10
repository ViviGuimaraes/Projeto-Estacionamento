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

//inporte do arqquivo de modelagem da Cor
require_once(SRC .'model/bd/cor.php');




//   Função responsável por tratar os dados para inserção de Cor
//   @author Vívian Guimaraes Vaz
//   @param Array $dados Informações da Cor - nome 
//   @return Bool True se foi inserido, se não Array com uma mensagem de erro
function inserirCor($nome){

    //validação para verificar se há conteúdo para a inserção da cor
    if (!empty($nome)){

        //validação para verificar se o campo obrigatório 'Nome' foi informado
        if(!empty($nome)){

             //chamando a model e passando a cor 
             if (insertCor($nome))
                return true;
             else 
                return MESSAGES['error']['Insert'][0];

        }else
            return MESSAGES['error']['Data'][1];   
    }else
         return MESSAGES['error']['Data'][0];
}


//echo inserirCor("purpura");














?>