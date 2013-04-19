<?php

class Admin_Model_EstadoMapper
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
            $this->setDbTable('Admin_Model_DbTable_Estado');
        }
        return $this->_dbTable;
    }

    public function fetchAll ()
    {
        $table = $this->getDbTable();
        $rowSet = $table->fetchAll();

        $estados = array ();
        foreach ($rowSet as $row) {
            $estados[$row->id] = new Admin_Model_Estado($row);
        }

        return $estados;
    }

    public function insert (array $data)
    {
        return $this->getDbTable()->insert($data);
    }

    public function update (array $data, $estadoId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $estadoId);
        return $table->update($data, $where);
    }

    public function delete ($estadoId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $estadoId);
        return $this->getDbTable()->delete($where);
    }

}

