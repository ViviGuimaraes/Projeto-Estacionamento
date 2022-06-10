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

//inporte do arqquivo de modelagem do Piso
require_once(SRC.'model/bd/piso.php');



//   Função responsável por tratar os dados para inserção do nome do Piso
//   @author Vívian Guimaraes Vaz
//   @param Array $dados Informações do  Piso - nome 
//   @return Bool True se foi inserido, se não Array com uma mensagem de erro
function inserirPiso($dados){

     //validação para verificar se há conteúdo para inserção Piso
     if(!empty($dados)){

        //validação para informar se o campo obrigatório 'nome foi informado'
        if(!empty($dados['nome']) && !empty($dados['ativo'])){

            //chamar a model e passar o nome do piso 
            if(insertPiso($dados))
                return true;
            else 
                return MESSAGES['error']['Insert'][0];
        }else
            return MESSAGES['error']['Data'][1]; 
     }else
     return MESSAGES['error']['Data'][0];
}

//print_r(inserirPiso($dados));


//   Função responsável por atualizar do dados da PIso
//   @author Vívian Guimaraes Vaz
//   @param Array $dados Informações do  Piso - nome, ativo, 
//   @return Bool True se foi inserido, se não Array com uma mensagem de erro
function atualizarPiso($dados){

    //validação para verifcar se há dados para atualizar piso
    if(!empty($dados)){

        //validação do id 
        if(is_numeric($dados['id']) && $dados['id'] > 0){

            //validação para informar se o campo obrigatório 'nome foi informado'
            if(!empty($dados['nome']) && !empty($dados['ativo'])){

                 // Chamando a model e passando os dados 
                 if(updatePiso($dados))
                    return true;
                 else
                     return MESSAGES['error']['Insert'][0];
            }else
                 return MESSAGES['error']['Data'][1];

        }else 
            return MESSAGES['error']['IDs'][0] . " ID do Setor é inválido";
           
    }else
         return MESSAGES['error']['Data'][0];       
    
}
print_r(atualizarPiso($dados));
?>