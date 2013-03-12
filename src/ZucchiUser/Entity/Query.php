<?php
/**
 * ZucchiUser (http://zucchi.co.uk)
 *
 * @link      http://github.com/zucchi/ZucchiUser for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */
namespace ZucchiUser\Entity;

use ZucchiDoctrine\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation AS Form;
use ZucchiDoctrine\Behavior\Timestampable\TimestampableTrait;
use Gedmo\Mapping\Annotation as Gedmo;
use ZucchiModel\Annotation as Model;

/**
 * Entity to store 
 * @author Matt Cockayne <matt@zucchi.co.uk>
 * @package ZucchiUser
 * @subpackage Entity
 * @property int $id
 * @property string $User
 * @property DateTime createdAt
 * @property DateTime updatedAt
 * 
 * @ORM\Entity
 * @ORM\Table(name="zucchi_user_queries")
 */
class Query extends AbstractEntity
{
    use TimestampableTrait;
    
    /**
     * Owner of the query
     * 
     * @var Collection
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Queries")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $User;
    
    /**
     * which "entity" the query relates to
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $entity;
    
    /**
     * visibility of the query to others
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $visibility;
    
    /**
     * name of the stored query
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    protected $name;
    
    /**
     * the request query string
     * 
     * @var string
     * @ORM\Column(type="text")
     */
    protected $query;
    
}