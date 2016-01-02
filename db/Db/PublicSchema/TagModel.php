<?php

namespace db\Db\PublicSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use db\Db\PublicSchema\AutoStructure\Tag as TagStructure;
use db\Db\PublicSchema\Tag;

/**
 * TagModel
 *
 * Model class for table tag.
 *
 * @see Model
 */
class TagModel extends Model
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
        $this->structure = new TagStructure;
        $this->flexible_entity_class = '\db\Db\PublicSchema\Tag';
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
