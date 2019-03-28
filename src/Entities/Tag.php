<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 18.03.19
 * Time: 08:32
 */

namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity (repositoryClass="Repositories\TagRepository")
 * @ORM\Table(name="tags")
 */


class Tag
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */

    protected $id = 0;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     */

    protected $title = "";

    /**
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="tags")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     **/

    protected $articles;

    use \Traits\ArrayMappable;
    
    /**
     * Tag constructor.
     */
    public function __construct(array  $data = [])
    {
        $this->mapFromArray($data);
        $this->articles = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    protected function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = clean($title);
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

    public function getArticles(){
        return $this->articles;
    }

}