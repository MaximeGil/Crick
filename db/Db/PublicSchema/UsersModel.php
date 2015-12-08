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
class UsersModel extends Model
{
    use WriteQueries;

    /**
     * __construct().
     *
     * Model constructor
     */
    public function __construct()
    {
        $this->structure = new UsersStructure();
        $this->flexible_entity_class = '\db\Db\PublicSchema\Users';
    }
}
