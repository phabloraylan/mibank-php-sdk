<?php
namespace MiBank;
class Cliente {

    private $chave_consulta;
    private $chave_api;
    private $chave_transferencia;
    
    public function setChaveConsulta($chave){
        $this->chave_consulta = $chave;
    }

    public function getChaveConsulta(){
        return $this->chave_consulta;
    }

    public function setChaveApi($chave){
        $this->chave_api = $chave;
    }

    public function getChaveApi(){
        return $this->chave_api;
    }

    public function setChaveTransferencia($chave){
        $this->chave_transferencia = $chave;
    }

    public function getChaveTransferencia(){
        return $this->chave_transferencia;
    }
}