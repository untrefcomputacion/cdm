<?php

class Default_Model_MateriaMapper
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
            $this->setDbTable('Default_Model_DbTable_Materia');
        }
        return $this->_dbTable;
    }

    public function getIds ()
    {
        $table = $this->getDbTable();
        $select = $table->select()
                ->from($table, array ('id'))
                ->where('id > 0')
                ->order('id ASC');

        $rowSet = $table->fetchAll($select);
        $ids = array ();
        foreach ($rowSet as $row) {
            $ids[] = $row->id;
        }

        return $ids;
    }

    public function fetchAll ()
    {
        $rowSet = $this->getDbTable()->fetchAll();

        $materias = array ();

        foreach ($rowSet as $row) {
            $materia = new Default_Model_Materia($row);
            $materia->setCorrelativa($materias[$row->correlativa]);

            $materias[$row->id] = $materia;
        }

        return $materias;
    }

    public function fetchAllArray ()
    {
        $rowSet = $this->getDbTable()->fetchAll()->toArray();

        foreach ($rowSet as $row) {
            $row['correlativa'] = $materias[$row['correlativa']];
            $materias[$row['id']] = $row;
        }

        return $materias;
    }

    /**
     * Devuelve un array con la siguiente estructura:
     *
     * array (
     *     'current' => Default_Model_Materia,
     *     'parent' => Default_Model_Materia,
     *     'dependent' => array (
     *         Default_Model_Materia,
     *         ...,
     *         Default_Model_Materia
     *     )
     * )
     *
     * Representa una materia, más todo su ambito de correlativas.
     *
     * @param int $materiaId
     * @return array de Default_Model_Materia
     * @deprecated
     */
    public function fetchAllCorrelativas ($materiaId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('id = ?', $materiaId);

        $result = $table->fetchAll($where)->current();
        $materia['current'] = new Default_Model_Materia($result);

        $correlativaDe = $result->findParentRow('Default_Model_DbTable_Materia');
        $materia['parent'] = new Default_Model_Materia($correlativaDe);

        $correlativaPara = $result->findDependentRowset('Default_Model_DbTable_Materia');
        foreach ($correlativaPara as $row) {
            $materia['dependent'][] = new Default_Model_Materia($row);
        }

        return $materia;
    }

    public function fetchByAnio ()
    {
        $table = $this->getDbTable();
        $select = $table->select()
                ->order('id ASC');
        $rowSet = $table->fetchAll($select);

        $materias = array ();

        foreach ($rowSet as $row) {
            $materia = new Default_Model_Materia();

            if ($row->correlativa !== '0') {
                $anioCorrelativa = substr($row->correlativa, 0, 1) ?: 0;
                $cuatrimestreCorrelativa = substr($row->correlativa, 1, 1) ?: 0;

                $correlativa = $materias[$anioCorrelativa][$cuatrimestreCorrelativa][$row->correlativa];
            } else if ($row->id !== '0') {
                $correlativa = $materias[0][0][0];
            } else {
                $correlativa = null;
            }

            $materia->setId($row->id)
                    ->setCodigo($row->codigo)
                    ->setNombre($row->nombre)
                    ->setAnio($row->anio)
                    ->setCuatrimestre($row->cuatrimestre)
                    ->setCorrelativa($correlativa)
                    ->setHoras($row->horas);

            $materias[$row->anio][$row->cuatrimestre][$row->id] = $materia;
        }

        return $materias;
    }

    /**
     * @deprecated
     */
    public function fixEncoding ()
    {
        $table = $this->getDbTable();
        $rowSet = $table->fetchAll();

        foreach ($rowSet as $row) {
            $data = array ('nombre' => iconv('ISO-8859-1', 'UTF-8', $row->nombre));
            $where = $table->getAdapter()->quoteInto('id = ?', $row->id);

            $table->update($data, $where);
        }
    }

}
