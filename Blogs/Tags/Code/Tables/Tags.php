<?php

namespace Cms\Blogs\Tags\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tags
 *
 * @ORM\Table(name="cms_blogs_tags", indexes={@ORM\Index(name="blog_id_index", columns={"blog_id"}), @ORM\Index(name="created_by_index", columns={"created_by"}), @ORM\Index(name="modified_by_index", columns={"modified_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Tags extends \Kazist\Table\BaseTable {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="blog_id", type="integer", length=11, nullable=false)
     */
    protected $blog_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="tag_id", type="integer", length=11, nullable=false)
     */
    protected $tag_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", length=11, nullable=false)
     */
    protected $created_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    protected $date_created;

    /**
     * @var integer
     *
     * @ORM\Column(name="modified_by", type="integer", length=11, nullable=false)
     */
    protected $modified_by;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    protected $date_modified;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set blog_id
     *
     * @param integer $blogId
     * @return Tags
     */
    public function setBlogId($blogId) {
        $this->blog_id = $blogId;

        return $this;
    }

    /**
     * Get blog_id
     *
     * @return integer 
     */
    public function getBlogId() {
        return $this->blog_id;
    }

    /**
     * Set tag_id
     *
     * @param integer $tagId
     * @return Tags
     */
    public function setTagId($tagId) {
        $this->tag_id = $tagId;

        return $this;
    }

    /**
     * Get tag_id
     *
     * @return integer 
     */
    public function getTagId() {
        return $this->tag_id;
    }

    /**
     * Get created_by
     *
     * @return integer 
     */
    public function getCreatedBy() {
        return $this->created_by;
    }

    /**
     * Get date_created
     *
     * @return \DateTime 
     */
    public function getDateCreated() {
        return $this->date_created;
    }

    /**
     * Get modified_by
     *
     * @return integer 
     */
    public function getModifiedBy() {
        return $this->modified_by;
    }

    /**
     * Get date_modified
     *
     * @return \DateTime 
     */
    public function getDateModified() {
        return $this->date_modified;
    }

}
