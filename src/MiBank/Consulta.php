<?php
namespace MiBank;

class Consulta {

    private $cliente;
    public function __construct($cliente){
        $this->cliente = $cliente;
    }

    public function getValidaConta($documento,$numero_conta){
        
        // Create a client with a base URI
        $client = new \GuzzleHttp\Client(['base_uri' => Http\Api::URL_BASE,'verify' => false]);

        try{
            $response = $client->request('GET', "/api/mibank/conferir-conta-documento?numero_conta=$numero_conta&documento=$documento");
            $body = json_decode($response->getBody(),true);
            return $body;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse(); 
            $erro = json_decode($response->getBody(),true)['descricao'];
            throw new Exception\MiBankException($erro,$response->getStatusCode());
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            throw new Exception\ServidorException('Erro inesperado, tente novamente mais tarde',$e->getResponse()->getStatusCode());
        }
    }

    public function getSaldo(){
        
        $token = $this->cliente->getChaveApi();
        // Create a client with a base URI
        $client = new \GuzzleHttp\Client(['base_uri' => Http\Api::URL_BASE,'verify' => false]);

        try{
            $response = $client->request('GET', "/api/conta/saldo-conta?chave_api=$token");
            $body = json_decode($response->getBody(),true);
            return $body['saldo'];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse(); 
            $erro = json_decode($response->getBody(),true)['error_description'];
            throw new Exception\MiBankException($erro,$response->getStatusCode());
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            throw new Exception\ServidorException('Erro inesperado, tente novamente mais tarde',$e->getResponse()->getStatusCode());
        }
    }

    public function getNumeroConta(){
        
        $token = $this->cliente->getChaveApi();
        // Create a client with a base URI
        $client = new \GuzzleHttp\Client(['base_uri' => Http\Api::URL_BASE,'verify' => false]);

        try{
            $response = $client->request('GET', "/api/conta/saldo-conta?chave_api=$token");
            $body = json_decode($response->getBody(),true);
            return $body['numero_conta'];
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse(); 
            $erro = json_decode($response->getBody(),true)['error_description'];
            throw new Exception\MiBankException($erro,$response->getStatusCode());
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            throw new Exception\ServidorException('Erro inesperado, tente novamente mais tarde',$e->getResponse()->getStatusCode());
        }
    }

    public function getTransacao($transacao){
        
        $token = $this->cliente->getChaveConsulta();
        // Create a client with a base URI
        $client = new \GuzzleHttp\Client(['base_uri' => Http\Api::URL_BASE,'verify' => false]);

        try{
            $response = $client->request('GET', '/api/conta/transacao?chave_api=' . $token . '&transacao=' . $transacao);
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

    public function getExtratoPJ($data,$pagina){
        
        $token = $this->cliente->getChaveApi();
        // Create a client with a base URI
        $client = new \GuzzleHttp\Client(['base_uri' => Http\Api::URL_BASE,'verify' => false]);

        try{
            $response = $client->request('GET', "/api/conta/extrato-by-data?chave_api=$token&data=$data&pagina=$pagina");
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