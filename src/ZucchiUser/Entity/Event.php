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

/**
 * audit of events triggered by the user 
 * 
 * @author Matt Cockayne <matt@zucchi.co.uk>
 * @package ZucchiUser
 * @subpackage Entity
 * @property int $id
 * @property string $User
 * @property DateTime createdAt
 * @property DateTime updatedAt
 * @property string $action
 * @property array $data
 * 
 * @ORM\Entity
 * @ORM\Table(name="zucchi_user_event")
 */
class Event extends AbstractEntity
{
    use TimestampableTrait;
    
    /** 
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;
    
    /**
     * Owner of the query
     * 
     * @var Collection
     * @ORM\ManyToOne(targetEntity="User")
     */
    public $User;
    
    /**
     * The action that is being audited
     * 
     * @var string
     * @ORM\Column(type="string")
     */
    public $action;
    
    /**
     * data relating to the action
     * 
     * @var array
     * @ORM\Column(type="json_array")
     */
    public $data;
    
}