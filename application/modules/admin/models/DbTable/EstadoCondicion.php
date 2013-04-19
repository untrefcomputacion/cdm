<?php

class Admin_Model_DbTable_EstadoCondicion extends Zend_Db_Table_Abstract
{

    protected $_name = 'estado_condicion';
    protected $_referenceMap = array (
        'Estado' => array (
            'columns' => 'estado_id',
            'refTableClass' => 'Admin_Model_DbTable_Estado',
            'refColumns' => 'id'
        )
    );

}

