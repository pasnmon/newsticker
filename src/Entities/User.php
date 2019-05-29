<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 18.03.19
 * Time: 14:19
 */

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity (repositoryClass="Repositories\UserRepository")
 * @ORM\Table(name="users")
 */

class User{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id = 0;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    protected $email = "";

    protected $password = "";

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $displayName = "";
    /**
     * @ORM\Column(type="string", length=255)
     */

    protected $hash = "";

    protected const HASH_ALGO = PASSWORD_BCRYPT;

    protected const HASH_OPTIONS = [
        "cost" => 12,
    ];
    /**
     * @ORM\OneToMany(targetEntity= "Article", mappedBy="user")
     */
    protected $articles;

    /**
     * @ORM\ManyToOne (targetEntity = "UserGroup", inversedBy="users")
     */
    protected $userGroup;

    use \Traits\ArrayMappable;

    public function __construct(array  $data = [])
    {
        $this->mapFromArray($data);
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return clean($this->getDisplayName());
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return clean($this->email,false);
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return clean($this->displayName,false);
    }

    /**
     * @param mixed $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }


    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = clean($email);
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->hashPassword();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserGroup()
    {
        return $this->userGroup;
    }

    public function getUserGroupId(){
        return $this->userGroup->getId();
    }

    /**
     * @param mixed $user
     */
    public function setUserGroup(?UserGroup $userGroup)
    {
        $this->userGroup = $userGroup;
    }

    public function clearArticles(){
        $this->articles->clear();
    }

    public function addArticle(Article $article){
        $this->articles->add($article);
    }

    public function hasArticle(Article $article){
        return $this->articles->contains($article);
    }

    public function removeArticle(Article $article)
    {
        $this->articles->removeElement($article);
    }

    public function verifyPasswordHash($password){
        return password_verify($password,$this->hash);
    }

    public function checkPasswordNeedsRehash(){
        return password_needs_rehash($this->hash,self::HASH_ALGO,self::HASH_OPTIONS);
    }

    public function hashPassword(){
        if (!empty($this->password)){
            $this->hash = password_hash($this->password,self::HASH_ALGO,self::HASH_OPTIONS);
        }
    }
}