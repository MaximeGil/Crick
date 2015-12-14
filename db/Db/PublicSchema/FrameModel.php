<?php

namespace db\Db\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use db\Db\PublicSchema\AutoStructure\Frame as FrameStructure;
use db\Db\PublicSchema\Frame;

/**
 * FrameModel
 *
 * Model class for table frame.
 *
 * @see Model
 */
class FrameModel extends Model
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
        $this->structure = new FrameStructure;
        $this->flexible_entity_class = '\db\Db\PublicSchema\Frame';
    }
}
