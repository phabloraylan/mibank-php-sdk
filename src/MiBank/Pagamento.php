<?php
namespace MiBank;

class Pagamento {

    private $cliente;
    public function __construct($cliente){
        $this->cliente = $cliente;
    }

    public function solicitar($valor,$descricao,$callback_url_success,$callback_url_fail){
        
        // Create a client with a base URI
        $client = new \GuzzleHttp\Client(['base_uri' => Http\Api::URL_BASE_PAGAMENTO,'verify' => false]);
        $token = $this->cliente->getChaveApi();
        try{
            $response = $client->request('POST', '', [
                'form_params' => [
                    'chave_api' => $token,
                    'valor' => $valor,
                    'descricao' => $descricao,
                    'callback_url_success' => $callback_url_success,
                    'callback_url_fail'  => $callback_url_fail
                ]]);
            echo $response->getBody();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse(); 
            $erro = json_decode($response->getBody(),true)['error_description'];
            throw new Exception\MiBankException($erro,$response->getStatusCode());
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            throw new Exception\ServidorException('Erro inesperado, tente novamente mais tarde',$e->getResponse()->getStatusCode());
        }
    }

}