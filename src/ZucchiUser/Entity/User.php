<?php
/**
 * ZucchiUser (http://zucchi.co.uk)
 *
 * @link      http://github.com/zucchi/ZucchiUser for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace ZucchiUser\Entity;

use Zucchi\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation AS Form;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * 
 * @author Matt Cockayne <matt@zucchi.co.uk>
 * @package ZucchiUser
 * @subpackage Entity
 * @property int $id
 * @property string $identity
 * @property string $credential
 * @property string $forename
 * @property string $email
 * @property bool $locked
 * 
 * @ORM\Entity
 * @ORM\Table(name="zucchi_user")
 */
class User extends AbstractEntity
{
    use TimestampableEntity;
    
    /**
     * 
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name":"StringLength", "options":{"min":1, "max":25}})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({"label":"Username:"})
     */
    public $identity;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    public $credential;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    public $forename;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    public $surname;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    public $email;
    
    /**
     * 
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     */
    public $locked;
}