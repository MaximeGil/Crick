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
    uuid = ':uuid' AND nameProject= ':name'
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
}
