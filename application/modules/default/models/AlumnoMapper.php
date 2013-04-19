<?php

class Default_Model_AlumnoMapper
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
            $this->setDbTable('Default_Model_DbTable_Alumno');
        }
        return $this->_dbTable;
    }

    public function createAlumno (array $alumno)
    {
        return $this->getDbTable()->insert($alumno);
    }

    public function updateAlumno (array $alumno, $userId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $userId);

        return $table->update($alumno, $where);
    }

    public function checkPassword ($userId, $password)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $userId);
        $where .= $table->getAdapter()->quoteInto(' AND password = MD5(?)', $password);

        $result = $table->fetchAll($where);

        if (count($result) == 1) {
            $alumno = new Default_Model_Alumno();
            $alumno->setId($result->id)
                    ->setEmail($result->email)
                    ->setNombre($result->nombre)
                    ->setApellido($result->apellido)
                    ->setCohorte($result->cohorte);
        }

        return $alumno;
    }

}

