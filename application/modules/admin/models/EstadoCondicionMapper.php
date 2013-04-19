<?php

class Admin_Model_EstadoCondicionMapper
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
            $this->setDbTable('Admin_Model_DbTable_EstadoCondicion');
        }
        return $this->_dbTable;
    }

    public function fetchAll ()
    {
        $table = $this->getDbTable();
        $rowSet = $table->fetchAll();

        $estadosCondicion = array ();
        foreach ($rowSet as $row) {
            $estadosCondicion[$row->id] = new Admin_Model_EstadoCondicion($row);
        }

        return $estadosCondicion;
    }

    public function update (array $data, $condicionId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $condicionId);

        return $table->update($data, $where);
    }

}

