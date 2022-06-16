<?php
/**
 * BilheteriaForm
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class BilheteriaForm extends TStandardForm
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
        $this->setActiveRecord('bilheteria');     // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_Bilheteria');
        $this->form->setFormTitle('Bilheteria');
        
        // create the form fields
        $id = new TEntry('id');
        $cliente_nome = new TDBUniqueSearch('cliente_nome', 'permission', 'Cliente', 'id', 'nome');
        $funcionario_nome = new TDBCombo('funcionario_nome', 'permission', 'Funcionario', 'id', 'nome');
        $brinquedo_nome = new TDBCombo('brinquedo_nome', 'permission', 'Brinquedo', 'id', 'nome');
        $brinquedo_preço = new TDBCombo('brinquedo_preço', 'permission', 'Brinquedo', 'id', 'preço');
        $pagamento = new TEntry('pagamento');
        $data_bilhete = new TDateTime('data_bilhete');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Cliente')], [$cliente_nome] );
        $this->form->addFields( [new TLabel('Funcionario')], [$funcionario_nome] );
        $this->form->addFields( [new TLabel('Brinquedo')], [$brinquedo_nome] );
        $this->form->addFields( [new TLabel('Preço Brinquedo')], [$brinquedo_preço] );
        $this->form->addFields( [new TLabel('Pagamento')], [$pagamento] );
        $this->form->addFields( [new TLabel('Data')], [$data_bilhete] );
        
        $id->setEditable(FALSE);
        $id->setSize('30%');
        $cliente_nome->setSize('70%');
        $cliente_nome->addValidation( _t('cliente_nome'), new TRequiredValidator );
        $funcionario_nome->setSize('70%');
        $funcionario_nome->addValidation( _t('funcionario_nome'), new TRequiredValidator );
        $brinquedo_nome->setSize('70%');
        $brinquedo_nome->addValidation( _t('brinquedo_nome'), new TRequiredValidator );
        $brinquedo_preço->setSize('70%');
        $brinquedo_preço->addValidation( _t('brinquedo_preço'), new TRequiredValidator );
        $brinquedo_preço->placeholder = 'R$00,00';
        $pagamento->setSize('70%');
        $pagamento->addValidation( _t('pagamento'), new TRequiredValidator );
        $data_bilhete->setSize('70%');
        $data_bilhete->addValidation( _t('data_bilhete'), new TRequiredValidator );
        
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction(array($this, 'onSave')), 'far:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('Clear'),  new TAction(array($this, 'onEdit')), 'fa:eraser red');
        $this->form->addActionLink(_t('Back'),new TAction(array('BilheteriaList','onReload')),'far:arrow-alt-circle-left blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', 'BilheteriaList'));
        $container->add($this->form);
        
        parent::add($container);
    }
}
