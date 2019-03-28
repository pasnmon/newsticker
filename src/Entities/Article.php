<?php
/**
 * Created by PhpStorm.
 * User: p.starkl
 * Date: 18.03.19
 * Time: 13:54
 */
namespace Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Webmasters\Doctrine\ORM\Util;

/**
 * @ORM\Entity (repositoryClass="Repositories\ArticleRepository")
 * @ORM\Table(name="articles")
 */

class Article{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */

    protected $id = 0;

    /**
     * @ORM\Column(name="title", type="text", length=80)
     */

    protected $title = "";

    /**
     * @ORM\Column(name="teaser", type="text", length=255)
     */

    protected $teaser = "";

    /**
     * @ORM\Column(name="news", type="text")
     */
    protected $news = "";

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="published_at", type="datetime")
     */
    protected $publishedAt;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="articles")
     */

    protected $user;

    /**
     * @ORM\Column(name="user_id", type="integer")
     */

    protected $userId;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="articles")
     * @ORM\JoinTable(name="tagging")
     */
    protected $tags;

    use \Traits\ArrayMappable;

    /**
     * Article constructor.
     * @param $publishedAt
     */

    public function __construct(array  $data = [])
    {
        $this->mapFromArray($data);
        $this->tags = new ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }

    public function getCreatedAt(){
        return new Util\DateTime($this->createdAt);
    }

    /**
     * @return mixed
     */
    public function getPublishedAt()
    {
        return new Util\DateTime($this->publishedAt);
    }

    /**
     * @param mixed $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        if (empty($publishedAt)){
            $publishedAt = "now";
        }
        $this->publishedAt = new Util\DateTime($publishedAt);
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
        $this->title = clean($title);
    }

    /**
     * @return mixed
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * @param mixed $teaser
     */
    public function setTeaser($teaser)
    {
        $this->teaser = clean($teaser);
    }

    /**
     * @return mixed
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * @param mixed $news
     */
    public function setNews($news)
    {
        $this->news = clean($news);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = clean($userId);
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(?User $user)
    {
        $this->user = $user;
    }

    public function clearTags(){
        $this->tags->clear();
    }

    public function addTag(Tag $tag){
        $this->tags->add($tag);
    }

    public function hasTag(Tag $tag){
        return $this->tags->contains($tag);
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    public function getTags(){
        return $this->tags;
    }

}