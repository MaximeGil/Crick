<?php

namespace db\Db\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;
use PommProject\Foundation\Where;
use db\Db\PublicSchema\AutoStructure\Project as ProjectStructure;
use db\Db\PublicSchema\Project;

/**
 * ProjectModel
 *
 * Model class for table project.
 *
 * @see Model
 */
class ProjectModel extends Model {

    use WriteQueries;

    /**
     * __construct()
     *
     * Model constructor
     *
     * @access public
     */
    public function __construct() {
        $this->structure = new ProjectStructure;
        $this->flexible_entity_class = '\db\Db\PublicSchema\Project';
    }

    public function findProjectExist($uuid, $nameProject) {

        // step 1
        $sql = <<<SQL
select
*
from
  :relation
where
    uuiduser = ':uuid' AND name= ':name'
SQL;

        // step 3
        $sql = strtr($sql, [
            ':relation' => $this->getStructure()->getRelation(),
            ':uuid' => $uuid,
            ':name' => $nameProject,
                ]
        );

        // step 4
        return $this->query($sql);
    }

    public function getProjects($uuid) {
        $sql = <<<SQL
select
project.uuid, project.name, to_char(SUM(stopframe - startframe), 'HH24:MI:SS') as timeperproject
from
   project INNER JOIN frame ON (project.uuid = frame.uuidproject)
where
    project.uuiduser = ':uuid'
group by project.uuid;
                             
SQL;

        $sql = strtr($sql, [
            ':relation' => $this->getStructure()->getRelation(),
            ':uuid' => $uuid,
            ':frame' => $this->getSession()
                    ->getModel('db\Db\PublicSchema\FrameModel')
                    ->getStructure()
                    ->getRelation(),
                ]
     
                );
        return $this->query($sql);
    }

    public function getProjectsInactive($uuid)
    {
                $sql = <<<SQL
select
uuid, name
from
   project
where
    uuiduser = ':uuid' AND uuid NOT IN(select uuidproject from frame)
;
                             
SQL;

        $sql = strtr($sql, [
            ':uuid' => $uuid,
                ]
     
                );
        return $this->query($sql);
    }
}
