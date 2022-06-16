<?php
/**
 * BrinquedoForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class BrinquedoForm extends TStandardForm
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
        $this->setActiveRecord('brinquedo');     // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Brinquedo');
        $this->form->setFormTitle('Brinquedo');
        
        // create the form fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $capacidade = new TEntry('capacidade');
        $preco = new TEntry('preço');
        $faixa = new TEntry('faixa_etaria');
        $manu = new TDateTime('manutençao');
        $manu->setMask('yyyy/mm/dd hh:ii');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        $this->form->addFields( [new TLabel('Capacidade')], [$capacidade] );
        $this->form->addFields( [new TLabel('Preço')], [$preco] );
        $this->form->addFields( [new TLabel('Faixa Etaria')], [$faixa] );
        $this->form->addFields( [new TLabel('Manutenção')], [$manu] );
        
        $id->setEditable(FALSE);
        $id->setSize('30%');
        $nome->setSize('70%');
        $nome->addValidation( _t('nome'), new TRequiredValidator );
        $capacidade->setSize('70%');
        $capacidade->addValidation( _t('capacidade'), new TRequiredValidator );
        $preco->setSize('70%');
        $preco->addValidation( _t('preço'), new TRequiredValidator );
        $preco->placeholder = 'R$00,00';
        $faixa->setSize('70%');
        $faixa->addValidation( _t('faixa_etaria'), new TRequiredValidator );
        $manu->setSize('70%');
        $manu->addValidation( _t('manutençao'), new TRequiredValidator );
        
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction(array($this, 'onSave')), 'far:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('Clear'),  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addActionLink(_t('Back'),new TAction(array('BrinquedoList','onReload')),'far:arrow-alt-circle-left blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'BrinquedoList'));
        $container->add($this->form);
        
        parent::add($container);
    }
}
