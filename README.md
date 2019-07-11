# miBank PHP SDK
> SDK PHP do mibank.solutions


Futuramente adicionaremos outras funções.

## Instalação

Via composer:

```sh
composer require phabloraylan/mibank-php-sdk
```

## Usando

Inclua o autoload em seu projeto, exemplo:

```php
require_once __DIR__ . '/vendor/autoload.php';
```

Instanciar a classe  de cliente:

```php
//Classe cliente
$cliente = new \MiBank\Cliente();

//Set as suas chaves miBank
$cliente = new \MiBank\Cliente(); 
$cliente->setChaveConsulta("CHAVE CONSULTA");
$cliente->setChaveApi("CHAVE API");
$cliente->setChaveTransferencia("CHAVE TRANFERÊNCIA");
```

Obtenha informações da transação:

```php
try{
    $consulta = new \MiBank\Consulta($cliente);
    $transacao = '123456789';
    $resultado = $consulta->getTransacao($transacao);
    print_r($resultado);//resultado em array
    
}catch(\MiBank\Exception\MiBankException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}catch(\MiBank\Exception\ServidorException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}
```

Consulte se a conta miBank é válida:

```php
try{

    $consulta = new \MiBank\Consulta($cliente);
    $documento = '123456789'; //CPF ou CNPJ sem mascára
    $numero_conta = '82144207'; //conta miBank sem mascára
    $resultado = $consulta->getValidaConta($documento,$numero_conta);
    print_r($resultado);//resultado em array

}catch(\MiBank\Exception\MiBankException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}catch(\MiBank\Exception\ServidorException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}
```

Consulte seu saldo:

```php
try{
    $consulta = new \MiBank\Consulta($cliente);
    $resultado = $consulta->getSaldo();
    echo $resultado;//retorna o valor
}catch(\MiBank\Exception\MiBankException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}catch(\MiBank\Exception\ServidorException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}
```

Consulte o número da sua conta miBank:

```php
try{
    $consulta = new \MiBank\Consulta($cliente);
    $resultado = $consulta->getNumeroConta();
    echo $resultado;//retorna a conta
}catch(\MiBank\Exception\MiBankException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}catch(\MiBank\Exception\ServidorException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}
```

Consulta o extrato paginado de 100 em 100 resultados:

```php
try{
    
    $consulta = new \MiBank\Consulta($cliente);
    $data = '25/09/2018';
    $pagina = 1;
    $resultado = $consulta->getExtratoPJ($data,$pagina);
    print_r($resultado);

}catch(\MiBank\Exception\MiBankException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}catch(\MiBank\Exception\ServidorException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}
```

Transferência entre contas miBank

```php
try{

    $transferencia = new \MiBank\Transferencia($cliente);
    $valor = 1;
    $conta_beneficiario = '123456789';
    $numero_controle = '1';//seu numero de controle (precisa ser único em cada transação)
    $resultado = $transferencia->efetuar($valor,$conta_beneficiario,$numero_controle);
    print_r($resultado);

}catch(\MiBank\Exception\MiBankException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}catch(\MiBank\Exception\ServidorException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}
```

Solicitar Pagamento:

```php
try{

    $pagamento = new \MiBank\Pagamento($cliente);
    $valor = 100;
    $descricao = 'Teste';
    $callback_url_success = 'http://localhost/success';
    $callback_url_fail = 'http://localhost/fail';
    $pagamento->solicitar($valor,$descricao,$callback_url_success,$callback_url_fail);

}catch(\MiBank\Exception\MiBankException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}catch(\MiBank\Exception\ServidorException $e){
    echo 'Mensagem: ' . $e->getMessage() . '<br>';
    echo 'Status: ' . $e->getCode();
}
/*
Após chamar a função solicitar, é exibida uma página miBank para o cliente continuar o pagamento, após receber os dados, o cliente será direcionado para seu servidor na url informada.

SUA URL de callback deve vir no seguinte formato:

http://sua-url-callback.com/?n=

onde n pode ser qualquer variavel necessária para seu controle e o valor que melhor convier. ex: ?cliente=03910

O retorno será neste formato:

http://sua-url-callback/?n=&key={sha1(CHAVE_API)}&transacao={numero_transacao}
*/
```