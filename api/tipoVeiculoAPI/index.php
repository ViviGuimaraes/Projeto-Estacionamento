<?php
// ______________________________________________________________
// Objetivo: Arquivo responsável pela manipulação da API
//            Obs(Este arquivo fará ponte entre a VIEW e a MODEL)
// Autor: Vívian Guimaães Vaz
//Data: 14/06/2022
//versão: 1.0
//________________________________________________________________________

//import do arquivo autoload, que fara as instancias do slim
require_once('vendor/autoload.php');


//Criando um objeto do slim chamado app, para configurar os EndPoints
$app = new \Slim\App();

  //import da controller de cor, que fará a busca de dados
  require_once('../module/config.php');
  require_once('../controller/controllerTipoVeiculo.php');

  /**
 * EndPoint: Responsável por listar os tipo de veiculos
 * @author Vívian Guimarães Vaz
 * @param JSON Dados da cor 
 * @return StatusCode 201 para inserido ou 400 para erro
 */
$app->get('/tipo', function($request, $response, $args){


    //solicita os dados para a controller
    if($dados = listaTipoVeiculo())
    {
        //Realiza a conversão do array de dados em formato JSON
        if($dadosJSON = createJSON($dados))
        {
            //Caso exista dados a serem retornados, informamamos o statusCode 200 e 
            //enviamos um JSON com todos os dados encontrados
            return $response    ->withStatus(200)
                                ->withHeader('Content-Type', 'application/json')
                                ->write($dadosJSON);
        }

    }else{
        
        //retorna um statusCode que significa que a requisição foi aceita, porém sem
        //conteudo de retorno 
        return $response    ->withStatus(204);
    }

});



$app->run();
?>