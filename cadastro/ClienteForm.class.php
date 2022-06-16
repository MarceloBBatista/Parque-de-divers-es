<?php
/**
 * ClienteForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class ClienteForm extends TStandardForm
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
        $this->setActiveRecord('cliente');     // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Cliente');
        $this->form->setFormTitle('Cliente');
        
        // create the form fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $endereco = new TEntry('endereço');
        $cidade = new TEntry('cidade');
        $estado = new TEntry('estado');
        $telefone = new TEntry('telefone');
        $telefone->setMask('9999-9999');
        $email = new TEntry('email');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        $this->form->addFields( [new TLabel('Endereço')], [$endereco] );
        $this->form->addFields( [new TLabel('Cidade')], [$cidade] );
        $this->form->addFields( [new TLabel('Estado')], [$estado] );
        $this->form->addFields( [new TLabel('Tel')], [$telefone] );
        $this->form->addFields( [new TLabel('Email')], [$email] );
        
        $id->setEditable(FALSE);
        $id->setSize('30%');
        $nome->setSize('70%');
        $nome->addValidation(('Nome'), new TRequiredValidator );
        $endereco->setSize('70%');
        $endereco->addValidation(('Endereço'), new TRequiredValidator );
        $cidade->setSize('70%');
        $cidade->addValidation(('Cidade'), new TRequiredValidator );
        $estado->setSize('70%');
        $estado->addValidation(('Estado'), new TRequiredValidator );
        $telefone->setSize('70%');
        $telefone->addValidation(('Tel'), new TRequiredValidator );
        $telefone->placeholder = '9999-9999';
        $email->setSize('70%');
        $email->addValidation(('Email'), new TRequiredValidator );
        $email->placeholder = 'm@email.com';
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction(array($this, 'onSave')), 'far:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('Clear'),  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addActionLink(_t('Back'),new TAction(array('ClienteList','onReload')),'far:arrow-alt-circle-left blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'ClienteList'));
        $container->add($this->form);
        
        parent::add($container);
    }
}
