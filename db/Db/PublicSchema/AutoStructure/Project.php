<?php
/**
 * This file has been automatically generated by Pomm's generator.
 * You MIGHT NOT edit this file as your changes will be lost at next
 * generation.
 */

namespace db\Db\PublicSchema\AutoStructure;

use PommProject\ModelManager\Model\RowStructure;

/**
 * Project
 *
 * Structure class for relation public.project.
 * 
 * Class and fields comments are inspected from table and fields comments.
 * Just add comments in your database and they will appear here.
 * @see http://www.postgresql.org/docs/9.0/static/sql-comment.html
 *
 *
 *
 * @see RowStructure
 */
class Project extends RowStructure
{
    /**
     * __construct
     *
     * Structure definition.
     *
     * @access public
     */
    public function __construct()
    {
        $this
            ->setRelation('public.project')
            ->setPrimaryKey(['idproject'])
            ->addField('idproject', 'int4')
            ->addField('uuid', 'uuid')
            ->addField('nameproject', 'varchar')
            ;
    }
}
