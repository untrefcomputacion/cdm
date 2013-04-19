<?php

class Default_Model_CurriculaMapper
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
            $this->setDbTable('Default_Model_DbTable_Curricula');
        }
        return $this->_dbTable;
    }

    public function initAlumno ($alumnoId, array $materiasId)
    {
        $table = $this->getDbTable();

        foreach ($materiasId as $materiaId) {
            $table->insert(array (
                'alumno_id' => $alumnoId,
                'materia_id' => $materiaId
            ));
        }
    }

    public function deleteAlumno ($alumnoId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('alumno_id = ?', $alumnoId);
        return $table->delete($where);
    }

    public function fetchAllArray ($alumnoId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('alumno_id = ?', $alumnoId);
        $rowSet = $table->fetchAll($where)->toArray();

        foreach ($rowSet as $row) {
            $curriculas[$row['materia_id']] = $row;
        }

        return $curriculas;
    }

    public function fetchByAlumno ($alumnoId)
    {
        $table = $this->getDbTable();
        $select = $table->select()
                ->where('alumno_id = ?', $alumnoId)
                ->order('materia_id ASC');

        $rowSet = $table->fetchAll($select);
        $curriculas = array ();
        foreach ($rowSet as $row) {
            $curricula = new Default_Model_Curricula();
            $curricula->setAlumnoId(intval($alumnoId));
            $curricula->setMateriaId(intval($row->materia_id));
            $curricula->setRegular(intval($row->regular));
            $curricula->setFinal(intval($row->final));
            $curricula->setNota($row->nota);

            $curriculas[$row->materia_id] = $curricula;
        }

        return $curriculas;
    }

    public function update (array $data, $alumnoId, $materiaId)
    {
        $table = $this->getDbTable();
        $where = $table->getAdapter()->quoteInto('alumno_id = ?', $alumnoId);
        $where .= $table->getAdapter()->quoteInto(' AND materia_id = ?', $materiaId);

        return $table->update($data, $where);
    }

}

