<?php
/**
 * FuncionarioForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class FuncionarioForm extends TStandardForm
{
    protected $form; // form
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        $ini  = AdiantiApplicationConfig::get();
        
        $this->setDatabase('permission');              // defines the database
        $this->setActiveRecord('funcionario');     // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Funcionario');
        $this->form->setFormTitle('Funcionario');
        
        // create the form fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $cpf = new TEntry('cpf');
        $cpf->setMask('000.000.000-00');
        $cidade = new TEntry('cidade');
        $funcao = new TEntry('funcao');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        $this->form->addFields( [new TLabel('CPF')], [$cpf] );
        $this->form->addFields( [new TLabel('Cidade')], [$cidade] );
        $this->form->addFields( [new TLabel('Funçao')], [$funcao] );
        
        $id->setEditable(FALSE);
        $id->setSize('30%');
        $nome->setSize('70%');
        $nome->addValidation( _t('nome'), new TRequiredValidator );
        $cpf->setSize('70%');
        $cpf->addValidation( _t('cpf'), new TRequiredValidator );
        $cidade->setSize('70%');
        $cidade->addValidation( _t('cidade'), new TRequiredValidator );
        $funcao->setSize('70%');
        $funcao->addValidation( _t('funcao'), new TRequiredValidator );
        
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction(array($this, 'onSave')), 'far:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('Clear'),  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addActionLink(_t('Back'),new TAction(array('FuncionarioList','onReload')),'far:arrow-alt-circle-left blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'FuncionarioList'));
        $container->add($this->form);
        
        parent::add($container);
    }
}
