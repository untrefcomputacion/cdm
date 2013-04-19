<?php

class Admin_Model_UsuarioMapper
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
            $this->setDbTable('Admin_Model_DbTable_Usuario');
        }
        return $this->_dbTable;
    }

    public function update (array $usuario, $userId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $userId);

        return $table->update($usuario, $where);
    }

    public function checkPassword ($userId, $password)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $userId);
        $where .= $table->getAdapter()->quoteInto(' AND password = MD5(?)', $password);

        $rowSet = $table->fetchAll($where);
        $usuario = new Admin_Model_Usuario($rowSet->current());
        return $usuario;
    }

}

