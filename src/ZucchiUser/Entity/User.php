<?php
/**
 * ZucchiUser (http://zucchi.co.uk)
 *
 * @link      http://github.com/zucchi/ZucchiUser for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zucchi Limited. (http://zucchi.co.uk)
 * @license   http://zucchi.co.uk/legals/bsd-license New BSD License
 */
namespace ZucchiUser\Entity;

use Zucchi\Filter\Cast;

use ZucchiDoctrine\Entity\AbstractEntity;
use ZucchiDoctrine\Entity\ChangeTrackingTrait;
use ZucchiDoctrine\Behavior\Timestampable\TimestampableTrait;

use ZucchiSecurity\Entity\AuthenticatableInterface;
use ZucchiSecurity\Entity\AuthorizableInterface;
use ZucchiSecurity\Entity\AuthorizableTrait;
use Zucchi\Debug\Debug;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use Zend\Form\Annotation AS Form;
use Zend\Crypt\Password\Bcrypt;

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
 * @ORM\HasLifecycleCallbacks
 * @Form\Name("user")
 * @Form\Hydrator("zucchidoctrine.entityhydrator")
 */
class User extends AbstractEntity implements
    AuthenticatableInterface,
    AuthorizableInterface
{
    use ChangeTrackingTrait;
    use TimestampableTrait;
    use AuthorizableTrait;
    
    /**
     * users identity
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
    protected $identity;
    
    /**
     * users credential
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
    protected $credential;
    
    /**
     * users forename
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
    protected $forename;
    
    /**
     * users surname
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
    protected $surname;
    
    /**
     * users emaiol address
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
    protected $email;
    
    /**
     * is the entity locked from authentication
     * 
     * @var boolean
     * @ORM\Column(type="boolean", nullable=false)
     * @Form\Type("\Zend\Form\Element\Radio")
     * @Form\Required(false)
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
     * @Form\Filter({"name": "Zucchi\Filter\Cast\Boolean"})
     */
    protected $locked;
    
    /**
     * security roles assigned to a user
     * @ORM\Column(type="json_array", nullable=false)
     * @Form\Type("\Zend\Form\Element\MultiCheckbox")
     * @Form\Required(false)
     * @Form\Options({
     *     "label":"Roles", 
     *     "bootstrap": {
     *         "help": {
     *             "style": "inline",
     *             "content": "The Roles available to the user"
     *         }
     *     }
     * })
     */
    protected $roles;
    
    /**
     * Stored Queries for use in the admin
     * 
     * @ORM\OneToMany(targetEntity="Query",mappedBy="User")
     * @Form\Exclude
     */
    protected $Queries;
    
    /**
     * Event log
     * 
     *@ORM\OneToMany(targetEntity="Event",mappedBy="User")
     *@Form\Exclude
     */
    protected $Events;
    
    /**
     * get a string representation of an entity
     * @return string
     */
    public function __toString()
    {
        return $this->forename . ' ' . $this->surname;
    }
    
    /**
     * function to encrypt the credential
     * 
     * @param string $credential
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function encryptCredential($credential = null)
    {
        $bcrypt = new Bcrypt();

        if (is_string($credential)) {
            return $bcrypt->create($credential);
        }
        
        // lifecycle event hook
        if ($this->isChanged('credential')) {
            $this->credential = $bcrypt->create($this->credential);
        }
    }
    
    /**
     * verify credential match
     * 
     * @param string $credential
     */
    public function verifyCredential($credential)
    {
        $bcrypt = new Bcrypt();
        return $bcrypt->verify($credential, $this->credential);
    }
    
    /**
     * function to identify if the authenticated entity is prevented from
     * authenticating
     * 
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }
    
    /**
     * retrieve the appropriate role/s of the entity
     * 
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }
}