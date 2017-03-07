<?php

namespace Cms\Contests\Winners\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Winners
 *
 * @ORM\Table(name="cms_contests_winners", indexes={@ORM\Index(name="blog_id_index", columns={"blog_id"}), @ORM\Index(name="category_id_index", columns={"category_id"}), @ORM\Index(name="user_id_index", columns={"user_id"}), @ORM\Index(name="contest_id_index", columns={"contest_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Winners extends \Kazist\Table\BaseTable {

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
     * @ORM\Column(name="category_id", type="integer", length=11, nullable=false)
     */
    protected $category_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", length=11, nullable=false)
     */
    protected $user_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="contest_id", type="integer", length=11, nullable=false)
     */
    protected $contest_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="contest_season", type="integer", length=11, nullable=false)
     */
    protected $contest_season;

    /**
     * @var string
     *
     * @ORM\Column(name="properties", type="text", nullable=true)
     */
    protected $properties;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_points", type="integer", length=11, nullable=true)
     */
    protected $total_points;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_values", type="integer", length=11, nullable=true)
     */
    protected $total_values;

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
     * @return Winners
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
     * Set category_id
     *
     * @param integer $categoryId
     * @return Winners
     */
    public function setCategoryId($categoryId) {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get category_id
     *
     * @return integer 
     */
    public function getCategoryId() {
        return $this->category_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Winners
     */
    public function setUserId($userId) {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId() {
        return $this->user_id;
    }

    /**
     * Set contest_id
     *
     * @param integer $contestId
     * @return Winners
     */
    public function setContestId($contestId) {
        $this->contest_id = $contestId;

        return $this;
    }

    /**
     * Get contest_id
     *
     * @return integer 
     */
    public function getContestId() {
        return $this->contest_id;
    }

    /**
     * Set contest_season
     *
     * @param integer $contestSeason
     * @return Winners
     */
    public function setContestSeason($contestSeason) {
        $this->contest_season = $contestSeason;

        return $this;
    }

    /**
     * Get contest_season
     *
     * @return integer 
     */
    public function getContestSeason() {
        return $this->contest_season;
    }

    /**
     * Set properties
     *
     * @param string $properties
     * @return Winners
     */
    public function setProperties($properties) {
        $this->properties = $properties;

        return $this;
    }

    /**
     * Get properties
     *
     * @return string 
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * Set total_points
     *
     * @param integer $totalPoints
     * @return Winners
     */
    public function setTotalPoints($totalPoints) {
        $this->total_points = $totalPoints;

        return $this;
    }

    /**
     * Get total_points
     *
     * @return integer 
     */
    public function getTotalPoints() {
        return $this->total_points;
    }

    /**
     * Set total_values
     *
     * @param integer $totalValues
     * @return Winners
     */
    public function setTotalValues($totalValues) {
        $this->total_values = $totalValues;

        return $this;
    }

    /**
     * Get total_values
     *
     * @return integer 
     */
    public function getTotalValues() {
        return $this->total_values;
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
