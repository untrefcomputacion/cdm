<?php

class Default_Model_EstadoMapper
{

    protected $_dbTable;

    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Default_Model_DbTable_Estado');
        }
        return $this->_dbTable;
    }

    public function fetchAll ()
    {
        $rowSet = $this->getDbTable()->fetchAll();

        $estados = array ();

        foreach ($rowSet as $row) {
            $estado = new Default_Model_Estado($row);

            $estados[$row->id] = $estado;
        }

        return $estados;
    }

}

