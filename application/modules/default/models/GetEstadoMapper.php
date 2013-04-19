<?php

class Default_Model_GetEstadoMapper
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
            $this->setDbTable('Default_Model_DbTable_GetEstado');
        }
        return $this->_dbTable;
    }

    public function fetchByAlumnoId ($alumnoId)
    {
        $table = $this->getDbTable();
        $select = $table->select()
                ->from($table, array ('id' => 'materia_id', 'class'))
                ->where('alumno_id = ?', $alumnoId);

        return $table->fetchAll($select)->toArray();
    }

}

