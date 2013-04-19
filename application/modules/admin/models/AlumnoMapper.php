<?php

class Admin_Model_AlumnoMapper
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
            $this->setDbTable('Admin_Model_DbTable_Alumno');
        }
        return $this->_dbTable;
    }

    public function fetchAll ()
    {
        $table = $this->getDbTable();
        $select = $table->select()
                ->order('id');
        $rowSet = $table->fetchAll($select);

        $alumnos = array ();

        foreach ($rowSet as $row) {
            $alumnos[$row->id] = new Admin_Model_Alumno($row);
        }

        return $alumnos;
    }

}

