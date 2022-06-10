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

//inporte do arqquivo de modelagem do tipo de veiculo
require_once(SRC.'model/bd/tipoVeiculo.php');


function inserirTipoVeiculo($nome){

    //validação para verificar se há conteúdo para inserção do tipo do veiculo
    if(!empty($nome)){

        //validação para informar se o campo obrigatório 'nome foi informado'
        if(!empty($nome)){

            //chamar a model e passar a cor 
            if(insertTipoVeiculo($nome))
                return true;
            else 
                return MESSAGES['error']['Insert'][0];
        }else
            return MESSAGES['error']['Data'][1]; 
    }else
     return MESSAGES['error']['Data'][0];
}

//
?>