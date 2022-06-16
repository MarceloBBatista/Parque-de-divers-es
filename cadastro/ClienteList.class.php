<?php
/**
 * ClienteList
 *
 * @version    1.0
 * @package    control
 * @subpackage admin
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class ClienteList extends TStandardList
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $deleteButton;
    protected $transformCallback;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        parent::setDatabase('permission');            // defines the database
        parent::setActiveRecord('cliente');   // defines the active record
        parent::setDefaultOrder('id', 'asc');         // defines the default order
        parent::addFilterField('id', '=', 'id'); // filterField, operator, formField
        parent::addFilterField('nome', 'like', 'nome'); // filterField, operator, formField
        parent::addFilterField('endereço', 'like', 'endereço'); // filterField, operator, formField
        parent::addFilterField('cidade', 'like', 'cidade'); // filterField, operator, formField
        parent::addFilterField('estado', 'like', 'estado'); // filterField, operator, formField
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_Cliente');
        $this->form->setFormTitle('Cliente');
        
        // create the form fields
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $endereco = new TEntry('endereço');
        $cidade = new TEntry('cidade');
        $estado = new TEntry('estado');
        $telefone = new TEntry('telefone');
        $email = new TEntry('email');
        
        // add the fields
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel(('Nome'))], [$nome] );
        $this->form->addFields( [new TLabel('Endereço')], [$endereco] );
        $this->form->addFields( [new TLabel('Cidade')], [$cidade] );
        $this->form->addFields( [new TLabel('Estado')], [$estado] );
        

        $id->setSize('30%');
        $nome->setSize('70%');
        $endereco->setSize('70%');
        $endereco->addValidation(('Endereço'), new TRequiredValidator );
        $cidade->setSize('70%');
        $cidade->addValidation(('Cidade'), new TRequiredValidator );
        $estado->setSize('70%');
        $estado->addValidation(('Estado'), new TRequiredValidator );
        $telefone->setSize('70%');
        $telefone->addValidation(('Tel'), new TRequiredValidator );
        $email->setSize('70%');
        $email->addValidation(('Email'), new TRequiredValidator );
        
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('Cliente_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addAction(('New'),  new TAction(array('ClienteForm', 'onEdit')), 'fa:plus green');
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->datatable = 'true';
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);
        
        // creates the datagrid columns
        $column_id = new TDataGridColumn('id', 'Id', 'center', 50);
        $column_nome = new TDataGridColumn('nome', ('Nome'), 'left');
        $column_endereco = new TDataGridColumn('endereço', ('Endereço'), 'left');
        $column_cidade = new TDataGridColumn('cidade', ('Cidade'), 'left');
        $column_estado = new TDataGridColumn('estado', ('Estado'), 'left');
        $column_telefone = new TDataGridColumn('telefone', ('Telefone'), 'left');
        $column_email = new TDataGridColumn('email', ('Email'), 'left');


        // add the columns to the DataGrid
        $this->datagrid->addColumn($column_id);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_endereco);
        $this->datagrid->addColumn($column_cidade);
        $this->datagrid->addColumn($column_estado);
        $this->datagrid->addColumn($column_telefone);
        $this->datagrid->addColumn($column_email);


        // creates the datagrid column actions
        $order_id = new TAction(array($this, 'onReload'));
        $order_id->setParameter('order', 'id');
        $column_id->setAction($order_id);
        
        $order_nome = new TAction(array($this, 'onReload'));
        $order_nome->setParameter('order', 'nome');
        $column_nome->setAction($order_nome);
        
        // create EDIT action
        $action_edit = new TDataGridAction(array('ClienteForm', 'onEdit'));
        $action_edit->setButtonClass('btn btn-default');
        $action_edit->setLabel(('Edit'));
        $action_edit->setImage('far:edit blue');
        $action_edit->setField('id');
        $this->datagrid->addAction($action_edit);
        
        // create DELETE action
        $action_del = new TDataGridAction(array($this, 'onDelete'));
        $action_del->setButtonClass('btn btn-default');
        $action_del->setLabel(('Delete'));
        $action_del->setImage('far:trash-alt red');
        $action_del->setField('id');
        $this->datagrid->addAction($action_del);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }
}
