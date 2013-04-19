<?php

class Default_Model_DbTable_Materia extends Zend_Db_Table_Abstract
{

    protected $_name = 'materia';
    protected $_referenceMap = array (
        'Correlativa' => array (
            'columns' => 'correlativa',
            'refTableClass' => 'Default_Model_DbTable_Materia',
            'refColumns' => 'id'
        )
    );

}

