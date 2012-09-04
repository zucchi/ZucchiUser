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
 * @property DateTime createdAt
 * @property DateTime updatedAt
 * 
 * @ORM\Entity
 * @ORM\Table(name="zucchi_user")
 * @Form\Name("user")
 * @Form\Hydrator("\Zend\Stdlib\Hydrator\ObjectProperty")
 */
class User extends AbstractEntity
{
    use TimestampableTrait;
    
    /**
     * 
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Form\Required(false)
     * @Form\Attributes({"type":"hidden"})
     */
    public $id;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", unique=true, nullable=false)
     * @Form\Required(true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({
     *     "label":"Username", 
     *     "bootstrap": {
     *         "help": {
     *             "style": "inline",
     *             "content": "The username for the user"
     *         }
     *     }
     * })
     */
    public $identity;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Form\Required(true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Attributes({"type":"password"})
     * @Form\Options({
     *     "label":"Password", 
     *     "bootstrap": {
     *         "help": {
     *             "style": "inline",
     *             "content": "The password for the user to login with"
     *         }
     *     }
     * })
     */
    public $credential;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Form\Required(true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({
     *     "label":"Forename", 
     *     "bootstrap": {
     *         "help": {
     *             "style": "inline",
     *             "content": "The users first name"
     *         }
     *     }
     * })
     */
    public $forename;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Form\Required(true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Attributes({"type":"text"})
     * @Form\Options({
     *     "label":"Surname", 
     *     "bootstrap": {
     *         "help": {
     *             "style": "inline",
     *             "content": "The users last name"
     *         }
     *     }
     * })
     */
    public $surname;
    
    /**
     * 
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Form\Required(true)
     * @Form\Filter({"name":"StringTrim"})
     * @Form\Validator({"name": "EmailAddress"})
     * @Form\Attributes({"type":"email"})
     * @Form\Options({
     *     "label":"Email", 
     *     "bootstrap": {
     *         "help": {
     *             "style": "inline",
     *             "content": "The email address for the user"
     *         }
     *     }
     * })
     */
    public $email;
    
    /**
     * 
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     * @Form\Type("\Zend\Form\Element\Radio")
     * @Form\Attributes({"type":"radio"})
     * @Form\Options({
     *     "options" : {"0":"No", "1":"Yes"},
     *     "label":"Locked", 
     *     "bootstrap": {
     *         "help": {
     *             "style": "inline",
     *             "content": "Has this user account been locked"
     *         }
     *     }
     * })
     */
    public $locked;
    
    /**
     *@ORM\OneToMany(targetEntity="Query",mappedBy="User")
     *@Form\Exclude
     */
    public $Queries;
    
    
}