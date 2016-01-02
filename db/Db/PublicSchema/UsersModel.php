<?php

namespace db\Db\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;
use db\Db\PublicSchema\AutoStructure\Users as UsersStructure;

/**
 * UsersModel.
 *
 * Model class for table users.
 *
 * @see Model
 */
class UsersModel extends Model {

    use WriteQueries;

    /**
     * __construct().
     *
     * Model constructor
     */
    public function __construct() {
        $this->structure = new UsersStructure();
        $this->flexible_entity_class = '\db\Db\PublicSchema\Users';
    }

    public function findUuidByName($emailUser) {

            // step 1
            $sql = <<<SQL
select
uuid
from
  :relation
where
    email = ':email'
SQL;

            // step 3
            $sql = strtr($sql, [
                ':relation' => $this->getStructure()->getRelation(),
                ':email' => $emailUser,
                    ]
            );

            // step 4
            return $this->query($sql);
        }
        
    public function deleteAll() {
        $sql = <<<SQL
                DELETE
                FROM 
                :relation
                
SQL;
        $sql = strtr($sql, [
            ':relation' => $this->getStructure()->getRelation(),
        ]);
        
        return $this->query($sql);
    }
    }
    