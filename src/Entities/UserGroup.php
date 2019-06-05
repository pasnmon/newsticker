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
 * @ORM\Entity (repositoryClass="Repositories\UserGroupRepository")
 * @ORM\Table(name="userGroups")
 */
class UserGroup
{

    use \Traits\ArrayMappable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id = 0;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $title = "";


    /**
     * @ORM\Column(type="string", length=2)
     */
    protected $rights = "00";           //Permission of the group: First value = Rights for Articles, Second value = Rights for user & usergroups

    /**
    * @ORM\OneToMany(targetEntity= "User", mappedBy="userGroup")
     */
    protected $users;

    public function __construct(array $data = [])
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

    /**
     * @return mixed
     */
    public function getRightsArticle()
    {
        return $this->rights[0];
    }

    public function getRightsUser()
    {
        return $this->rights[1];
    }

    public function hasArticleRights(){
        return $this->getRightsArticle() == 1;
    }

    public function hasUserRights(){
        return $this->getRightsUser() == 1;
    }
    /**
     * @param mixed $rights
     */
    public function setRightsArticle($rights)
    {
        $this->rights = $rights . $this->rights[1];
    }

    public function setRightsUser($rights)
    {
        $this->rights = $this->rights[0] . $rights;
    }

    public function clearUsers()
    {
        $this->users->clear();
    }

    public function addUser(User $user)
    {
        $this->users->add($user);
    }

    public function hasUser(User $user)
    {
        return $this->users->contains($user);
    }

    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    public function getUsers(){
        return $this->users;
    }

}