<?php 

    /*****
     *  $request    - Recebe dados do corpo da requisição (JSON, FORM/DATA, XML, etc)
     *  $response   - Envia dados de retorno da API
     *  $args       - Permite receber dados de atributos na API
     *  
     *  Os metodos de requisição para uma API são:
     *  GET         - para buscar dados
     *  POST        - para inserir um novo dado
     *  DELETE      - para apagar dados
     *  PUT/PATCH   - para editar um dados já existente
     *          O mais utilizado é o PUT 
     * 
     * *****/

    //import do arquivo autoload, que fara as instancias do slim
    require_once('vendor/autoload.php');


    //Criando um objeto do slim chamado app, para configurar os EndPoints
    $app = new \Slim\App();

    //EndPoint: Requisição para listar todos os contatos
    $app->get('/contatos', function($request, $response, $args){
        //import da controller de contatos, que fará a busca de dados
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');

        //solicita os dados para a controller
        if($dados = listarContato())
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
        }else
        {
            //retorna um statusCode que significa que a requisição foi aceita, porém sem
            //conteudo de retorno 
            return $response    ->withStatus(204);
        }
        
    });

    //EndPoint: Requisição para listar contatos pelo id
    $app->get('/contatos/{id}', function($request, $response, $args){
        
        //recebe o ID do registro que deverá ser retornado pela API
        //Esse ID esta chegando pela váriavel criada no endpoint
        $id =  $args['id'];
        
        //import da controller de contatos, que fará a busca de dados
        require_once('../modulo/config.php');
        require_once('../controller/controllerContatos.php');

        //solicita os dados para a controller
        if($dados = buscarContato($id))
        {
            //Verifica se houve algum tipo de erro no retorno dos dados da controller
            if(!isset($dados['idErro']))
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
            }else
            {
                //converte para JSON o erro, pois a controller retorna em array
                $dadosJSON = createJSON($dados);

                //Retorna um erro que significa que o cliente passou dados errados
                return $response    ->withStatus(404)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('{"message": "Dados inválidos",
                                              "Erro": '.$dadosJSON.'  
                                             }');
            }
        }else
        {
            //retorna um statusCode que significa que a requisição foi aceita, porém sem
            //conteudo de retorno 
            return $response    ->withStatus(204);
        }


    });

    //EndPoint: requisição para deletar um contato pelo id
    $app->delete('/contatos/{id}', function($request, $response, $args){
        
        if(is_numeric($args['id']))
        {
            //Recebe o ID enviado no EndPoint através da variavel ID
            $id = $args['id'];

            //import da controller de contatos, que fará a busca de dados
            require_once('../modulo/config.php');
            require_once('../controller/controllerContatos.php');

            //Busca o nome da foto para ser excluida na controlller
            if ($dados = buscarContato($id))
            {
                //Recebe o nome da foto que a controller retornou
                $foto = $dados['foto'];

                //Cria um array com o ID e o nome da foto a ser enviada para controller excluir o registro
                $arrayDados = array (
                    "id"    =>  $id,
                    "foto"  =>  $foto
                );
                //chama a função de excluir o contato, encaminhando o array com o ID e a foto
                $resposta = excluirContato($arrayDados);
                
                if(is_bool($resposta) && $resposta == true)
                {
                    //Retorna um erro que significa que o cliente informou um ID inválido
                    return $response    ->withStatus(200)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->write('{"message": "Registro excluído com sucesso!"}');
                
                }elseif(is_array($resposta) && isset($resposta['idErro'])){
                    //Validação referente ao erro 5, que significa 
                    //que o registro foi excluído do BD e a imagem não existia no servidor
                    if ($resposta['idErro'] == 5)
                    {
                        //Retorna um erro que significa que o cliente informou um ID inválido
                        return $response    ->withStatus(200)
                                            ->withHeader('Content-Type', 'application/json')
                                            ->write('{"message": "Registro excluído com sucesso, porém houve um problema na exclusão da imagem na pasta do servidor!"}');
                    }else{
                        //converte para JSON o erro, pois a controller retorna em array
                        $dadosJSON = createJSON($resposta);

                        //Retorna um erro que significa que o cliente passou dados errados
                        return $response    ->withStatus(404)
                                            ->withHeader('Content-Type', 'application/json')
                                            ->write('{"message": "Houve um problema no processo de excluir.",
                                                    "Erro": '.$dadosJSON.'  
                                                    }');
                    }
                    
                }


            }else{
                //Retorna um erro que significa que o cliente informou um ID inválido
                return $response    ->withStatus(404)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('{"message": "O ID informado não existe na base de dados."}');
            }

        }else{
            //Retorna um erro que significa que o cliente passou dados errados
            return $response    ->withStatus(404)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message": "É obrigatório informar um ID com formato válido (número)"}');
        }
        
        
        
    });

    //EndPoint: Requisição para inserir um novo os contato
    $app->post('/contatos', function($request, $response, $args){

        //Recebe do header da requisição qual será o content-Type
        $contentTypeHeader = $request->getHeaderLine('Content-Type');

        //Cria um array, pois dependendo do content-type temos mais informações separadas pelo (;) 
        $contentType =  explode(";", $contentTypeHeader);

        switch ($contentType[0]) {
            case 'multipart/form-data':

                //Recebe os dados comuns enviado pelo corpo da requisição 
                $dadosBody = $request->getParsedBody();

                //Recebe uma imagem enviada pelo corpo da requisição 
                $uploadFiles = $request->getUploadedFiles();

                //Cria um array com todos os dados que chegaram pela requisição, devido aos dados serem protegidos,
                //criamos um array e recuperamos os dados pelos metodos do objeto
                $arrayFoto = array (    "name"      => $uploadFiles['foto']->getClientFileName(),
                                        "type"      => $uploadFiles['foto']->getClientMediaType(),    
                                        "size"      => $uploadFiles['foto']->getSize(),
                                        "tmp_name"  => $uploadFiles['foto']->file
                                    );
                //Cria um chave chamada "foto" para colocar todos os dados do objeto, conforme é gerado em form HTML
                $file = array("foto" => $arrayFoto);                    

                //Cria um array com todos os dados comuns e do arquivo que será enviado para o servidor
                $arrayDados = array (   $dadosBody,
                                        "file" => $file   
                );
                
                //import da controller de contatos, que fará a busca de dados
                require_once('../modulo/config.php');
                require_once('../controller/controllerContatos.php');
                
                //Chama a função da controller para inserir os dados
                $resposta = inserirContato($arrayDados);

                if(is_bool($resposta) && $resposta == true)
                {
                    return $response    ->withStatus(201)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->write('{"message": "Registros inserido com sucesso."}');

                }elseif (is_array($resposta) && $resposta['idErro']){

                    //Cria o JSON dos dados do erro
                    $dadosJSON = createJSON($resposta);

                    return $response    ->withStatus(400)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->write('{"message": "Houve um problema no processo de inserir.",
                                                    "Erro": '.$dadosJSON.'  
                                                    }');
                }

                break;
            case 'application/json':

                $dadosBody = $request->getParsedBody();
                var_dump($dadosBody);
                die;

                return $response    ->withStatus(200)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('{"message": "formato selecionado foi JSON"}');
                break;
            default:
                return $response    ->withStatus(400)
                                    ->withHeader('Content-Type', 'application/json')
                                    ->write('{"message": "Formato do Content-Type não é válido para esta requisisção"}');
                break;
        }
    });

    //EndPoint: Requisição para alterar um contato, simulando o PUT
    $app->post('/contatos/{id}', function($request, $response, $args){

        if(is_numeric($args['id']))
        {
            //Recebe o ID enviado no EndPoint através da variavel ID
            $id = $args['id'];

             //Recebe do header da requisição qual será o content-Type
            $contentTypeHeader = $request->getHeaderLine('Content-Type');

            //Cria um array, pois dependendo do content-type temos mais informações separadas pelo (;) 
            $contentType =  explode(";", $contentTypeHeader);

            switch ($contentType[0]) {
                case 'multipart/form-data':
                    //import da controller de contatos, que fará a busca de dados
                    require_once('../modulo/config.php');
                    require_once('../controller/controllerContatos.php');

                    //chama a função para buscar a foto que já esta salva no BD
                    if($dadosContato = buscarContato($id))
                    {

                        $fotoAtual = $dadosContato['foto'];

                        //Recebe os dados comuns enviado pelo corpo da requisição 
                        $dadosBody = $request->getParsedBody();

                        //Recebe uma imagem enviada pelo corpo da requisição 
                        $uploadFiles = $request->getUploadedFiles();

                        //Cria um array com todos os dados que chegaram pela requisição, devido aos dados serem protegidos,
                        //criamos um array e recuperamos os dados pelos metodos do objeto
                        $arrayFoto = array (    "name"      => $uploadFiles['foto']->getClientFileName(),
                                                "type"      => $uploadFiles['foto']->getClientMediaType(),    
                                                "size"      => $uploadFiles['foto']->getSize(),
                                                "tmp_name"  => $uploadFiles['foto']->file
                                            );
                        //Cria um chave chamada "foto" para colocar todos os dados do objeto, conforme é gerado em form HTML
                        $file = array("foto" => $arrayFoto);                    

                        //Cria um array com todos os dados comuns e do arquivo que será enviado para o servidor
                        $arrayDados = array (   $dadosBody,
                                                "file"  => $file,
                                                "id"    => $id,
                                                "foto"  => $fotoAtual     
                        );
                        
                                          
                        //Chama a função da controller para inserir os dados
                        $resposta = atualizarContato($arrayDados);

                        if(is_bool($resposta) && $resposta == true)
                        {
                            return $response    ->withStatus(200)
                                                ->withHeader('Content-Type', 'application/json')
                                                ->write('{"message": "Registro atualizado com sucesso."}');

                        }elseif (is_array($resposta) && $resposta['idErro']){

                            //Cria o JSON dos dados do erro
                            $dadosJSON = createJSON($resposta);

                            return $response    ->withStatus(400)
                                                ->withHeader('Content-Type', 'application/json')
                                                ->write('{"message": "Houve um problema no processo de inserir.",
                                                            "Erro": '.$dadosJSON.'  
                                                            }');
                        }
                    }else{
                        
                        //Retorna um erro que significa que o cliente informou um ID inválido
                        return $response    ->withStatus(404)
                                            ->withHeader('Content-Type', 'application/json')
                                            ->write('{"message": "O ID informado não existe na base de dados."}');
                    }

                    break;
                case 'application/json':

                    $dadosBody = $request->getParsedBody();
                    var_dump($dadosBody);
                    die;

                    return $response    ->withStatus(200)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->write('{"message": "formato selecionado foi JSON"}');
                    break;
                default:
                    return $response    ->withStatus(400)
                                        ->withHeader('Content-Type', 'application/json')
                                        ->write('{"message": "Formato do Content-Type não é válido para esta requisisção"}');
                    break;
            }
        }else
        {
            //Retorna um erro que significa que o cliente passou dados errados
            return $response    ->withStatus(404)
                                ->withHeader('Content-Type', 'application/json')
                                ->write('{"message": "É obrigatório informar um ID com formato válido (número)"}');
        }
    });

    //Executa todos os EndPoints
    $app->run();
?>