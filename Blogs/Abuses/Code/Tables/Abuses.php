<?php

namespace Cms\Blogs\Abuses\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abuses
 *
 * @ORM\Table(name="cms_blogs_abuses", indexes={@ORM\Index(name="blog_id_index", columns={"blog_id"}), @ORM\Index(name="created_by_index", columns={"created_by"}), @ORM\Index(name="modified_by_index", columns={"modified_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Abuses extends \Kazist\Table\BaseTable {

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
     * @var string
     *
     * @ORM\Column(name="reason", type="text", nullable=false)
     */
    protected $reason;

    /**
     * @var integer
     *
     * @ORM\Column(name="verified", type="integer", length=11, nullable=true)
     */
    protected $verified;

    /**
     * @var integer
     *
     * @ORM\Column(name="abuse", type="integer", length=11, nullable=true)
     */
    protected $abuse;

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
     * @return Abuses
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
     * Set reason
     *
     * @param string $reason
     * @return Abuses
     */
    public function setReason($reason) {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason() {
        return $this->reason;
    }

    /**
     * Set verified
     *
     * @param integer $verified
     * @return Abuses
     */
    public function setVerified($verified) {
        $this->verified = $verified;

        return $this;
    }

    /**
     * Get verified
     *
     * @return integer 
     */
    public function getVerified() {
        return $this->verified;
    }

    /**
     * Set abuse
     *
     * @param integer $abuse
     * @return Abuses
     */
    public function setAbuse($abuse) {
        $this->abuse = $abuse;

        return $this;
    }

    /**
     * Get abuse
     *
     * @return integer 
     */
    public function getAbuse() {
        return $this->abuse;
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
