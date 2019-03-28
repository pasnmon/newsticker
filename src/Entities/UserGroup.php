<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 21.03.19
 * Time: 10:35
 */

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity (repositoryClass="Repositories\UserRepository")
 * @ORM\Table(name="userGroups")
 */
class UserGroup
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity= "User", mappedBy="userGroup")
     */
    protected $id = 0;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $title = "";

    protected $users;

    use \Traits\ArrayMappable;

    public function __construct(array  $data = [])
    {
        $this->mapFromArray($data);
        $this->users = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }


    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function clearUsers(){
        $this->users->clear();
    }

    public function addUser(User $user){
        $this->users->add($user);
    }

    public function hasUser(User $user){
        return $this->users->contains($user);
    }

    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }
}