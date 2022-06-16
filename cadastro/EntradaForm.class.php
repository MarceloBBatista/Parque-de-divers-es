<?php
/**
 * EntradaForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class EntradaForm extends TStandardForm
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
        $this->setActiveRecord('entrada');     // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Entrada');
        $this->form->setFormTitle('Entrada');
        
        // create the form fields
        $id = new TEntry('id');
        $cliente_nome = new TDBUniqueSearch('cliente_nome', 'permission', 'Cliente', 'id', 'nome');
        $hora_entrada = new TDateTime('hora_entrada');
        $hora_entrada->setMask('yyyy/mm/dd hh:ii');
        $hora_saida = new TDateTime('hora_saida');
        $hora_saida->setMask('yyyy/mm/dd hh:ii');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Cliente')], [$cliente_nome] );
        $this->form->addFields( [new TLabel('Entrada')], [$hora_entrada] );
        $this->form->addFields( [new TLabel('Saida')], [$hora_saida] );
        
        $id->setEditable(FALSE);
        $id->setSize('30%');
        $cliente_nome->setSize('70%');
        $cliente_nome->addValidation(('Nome'), new TRequiredValidator );
        $hora_entrada->setSize('70%');
        $hora_entrada->addValidation(('Entrada'), new TRequiredValidator );
        $hora_saida->setSize('70%');

        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction(array($this, 'onSave')), 'far:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('Clear'),  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addActionLink(_t('Back'),new TAction(array('EntradaList','onReload')),'far:arrow-alt-circle-left blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'EntradaList'));
        $container->add($this->form);
        
        parent::add($container);
    }
}
