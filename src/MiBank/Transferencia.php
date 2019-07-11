<?php
namespace MiBank;

class Transferencia {

    private $cliente;
    public function __construct($cliente){
        $this->cliente = $cliente;
    }

    public function efetuar($valor,$conta_beneficiario,$numero_controle){
        
        // Create a client with a base URI
        $client = new \GuzzleHttp\Client(['base_uri' => Http\Api::URL_BASE,'verify' => false]);
        $token = $this->cliente->getChaveTransferencia();
        try{
            $response = $client->request('POST', '/api/transferencia/transferir-por-chave', [
                'json' => [
                    'chave_transferencia' => $token,
                    'valor' => $valor,
                    'conta_beneficiario' => $conta_beneficiario,
                    'numero_controle' => $numero_controle
                ]]);
            $body = json_decode($response->getBody(),true);
            return $body;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse(); 
            $erro = json_decode($response->getBody(),true)['error_description'];
            throw new Exception\MiBankException($erro,$response->getStatusCode());
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            throw new Exception\ServidorException('Erro inesperado, tente novamente mais tarde',$e->getResponse()->getStatusCode());
        }
    }

}