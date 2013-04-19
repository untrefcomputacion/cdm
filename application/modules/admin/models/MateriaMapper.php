<?php

class Admin_Model_MateriaMapper
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
            $this->setDbTable('Admin_Model_DbTable_Materia');
        }
        return $this->_dbTable;
    }

    public function fetchAll ()
    {
        $table = $this->getDbTable();
        $select = $table->select()
                ->order('id');
        $rowSet = $table->fetchAll($select);

        $materias = array ();

        foreach ($rowSet as $row) {
            $materias[$row->id] = new Admin_Model_Materia($row);
        }

        return $materias;
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

