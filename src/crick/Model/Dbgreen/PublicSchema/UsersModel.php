<?php

namespace Vendor\Project\Model\Dbgreen\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use Vendor\Project\Model\Dbgreen\PublicSchema\AutoStructure\Users as UsersStructure;
use Vendor\Project\Model\Dbgreen\PublicSchema\Users;

/**
 * UsersModel
 *
 * Model class for table users.
 *
 * @see Model
 */
class UsersModel extends Model
{
    use WriteQueries;

    /**
     * __construct()
     *
     * Model constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->structure = new UsersStructure;
        $this->flexible_entity_class = '\Vendor\Project\Model\Dbgreen\PublicSchema\Users';
    }
}
