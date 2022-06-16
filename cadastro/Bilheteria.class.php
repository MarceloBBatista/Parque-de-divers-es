<?php
/**
 * Bilhetereia
 *
 * @version    1.0
 * @package    model
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class Bilheteria extends TRecord
{
    const TABLENAME = 'bilheteria';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}

    private $cliente;
    private $brinquedo;
    private $funcionario;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cliente_nome'); //ADIÇÃO DOS ATRIBUTOS DA TABELA 
        parent::addAttribute('funcionario_nome');
        parent::addAttribute('brinquedo_nome');
        parent::addAttribute('brinquedo_preço');
        parent::addAttribute('pagamento');
        parent::addAttribute('data_bilhete');
    }

    public function get_nome_cliente() //Função get para pegar o nome do cliente da tabela cliente para a bilheteria
    {
        if (empty($this->cliente))
            $this->cliente = new Cliente($this->cliente_nome);
        return $this->cliente->nome;
    }

    public function get_nome_brinquedo()
    {
        if (empty($this->brinquedo))
            $this->brinquedo = new Brinquedo($this->brinquedo_nome);
        return $this->brinquedo->nome;
    }
    
    public function get_nome_funcionario()
    {
        if (empty($this->funcionario))
            $this->funcionario = new Funcionario($this->funcionario_nome);
        return $this->funcionario->nome;
    }
    
    public function get_preco_brinquedo()
    {
        if (empty($this->brinquedo))
            $this->brinquedo = new Brinquedo($this->brinquedo_preço);
        return $this->brinquedo->preço;
    }
    
}
