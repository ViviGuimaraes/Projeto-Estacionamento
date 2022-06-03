<?php
/**
 * Objetivo: Arquivo de constantes e variáveis do projeto
 * Autor: Thales Santos
 * Data: 02/06/2022
 * Versão: 1.0
 */


/***************************             VARIÁVEIS E CONSTANTES GLOBAIS DO PROJETO              *********************************** */
//  Constantes para estabelecer a conexão com o BD:
const DB_SERVER = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = 'bcd127';
const DB_DATABASE = 'dbEstacionamento';

// Caminho relativo
define("SRC", $_SERVER['DOCUMENT_ROOT'] . '/fastparking');



/***************************             FUNÇÕES GLOBAIS DO PROJETO              *********************************** */

 /**
 * Função para  converter um Array em um formato JSON
 * @author Thales Santos
 * @param Array $arrayDados Array com os dados que serão transformados em JSON
 * @return JSON Contém os dados do array convertidos para JSON
 */
function createJSON($arrayDados){
    // Validação para tratar array sem dados
    if(!empty($arrayDados)) {
        // Configura o padrão da conversão em um formato JSON
        header('Content-Type: application/json');
    
        $dadosJSON = json_encode($arrayDados);
    
        return $dadosJSON;
    } else 
        return false;
}


?>