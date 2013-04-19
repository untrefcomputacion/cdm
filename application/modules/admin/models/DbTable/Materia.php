<?php

class Admin_Model_DbTable_Materia extends Zend_Db_Table_Abstract
{

    protected $_name = 'materia';
    protected $_referenceMap = array (
        'Correlativa' => array (
            'columns' => 'correlativa',
            'refTableClass' => 'Admin_Model_DbTable_Materia',
            'refColumns' => 'id'
        )
    );

}

