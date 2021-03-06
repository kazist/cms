<?php

namespace Cms\Articles\Code\Tables;

use Doctrine\ORM\Mapping as ORM;

/**
 * Articles
 *
 * @ORM\Table(name="cms_articles", indexes={@ORM\Index(name="contest_id_index", columns={"contest_id"}), @ORM\Index(name="category_id_index", columns={"category_id"}), @ORM\Index(name="created_by_index", columns={"created_by"}), @ORM\Index(name="modified_by_index", columns={"modified_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Articles extends \Kazist\Table\BaseTable {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    protected $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="contest_id", type="integer", length=11, nullable=true)
     */
    protected $contest_id;

    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", length=11, nullable=false)
     */
    protected $category_id;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="text", nullable=false)
     */
    protected $article;

    /**
     * @var string
     *
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    protected $short_description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordering", type="integer", length=11, nullable=true)
     */
    protected $ordering;

    /**
     * @var integer
     *
     * @ORM\Column(name="has_comment", type="integer", length=11, nullable=true)
     */
    protected $has_comment;

    /**
     * @var integer
     *
     * @ORM\Column(name="has_opinion", type="integer", length=11, nullable=true)
     */
    protected $has_opinion;

    /**
     * @var integer
     *
     * @ORM\Column(name="point_counted", type="integer", length=11, nullable=true)
     */
    protected $point_counted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_up", type="datetime", nullable=true)
     */
    protected $publish_up;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_down", type="datetime", nullable=true)
     */
    protected $publish_down;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="contest_start_date", type="datetime", nullable=true)
     */
    protected $contest_start_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="contest_end_date", type="datetime", nullable=true)
     */
    protected $contest_end_date;

    /**
     * @var integer
     *
     * @ORM\Column(name="contest_season", type="integer", length=11, nullable=true)
     */
    protected $contest_season;

    /**
     * @var integer
     *
     * @ORM\Column(name="contest_closed", type="integer", length=11, nullable=true)
     */
    protected $contest_closed;

    /**
     * @var integer
     *
     * @ORM\Column(name="point_accumulated", type="integer", length=11, nullable=true)
     */
    protected $point_accumulated;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_points", type="integer", length=11, nullable=true)
     */
    protected $total_points;

    /**
     * @var integer
     *
     * @ORM\Column(name="published", type="integer", length=11, nullable=true)
     */
    protected $published;

    /**
     * @var integer
     *
     * @ORM\Column(name="moderated", type="integer", length=11, nullable=true)
     */
    protected $moderated;

    /**
     * @var integer
     *
     * @ORM\Column(name="featured", type="integer", length=11, nullable=true)
     */
    protected $featured;

    /**
     * @var integer
     *
     * @ORM\Column(name="social_share", type="integer", length=11, nullable=true)
     */
    protected $social_share;

    /**
     * @var integer
     *
     * @ORM\Column(name="hit", type="integer", length=11, nullable=true)
     */
    protected $hit;

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
     * Set title
     *
     * @param string $title
     * @return Articles
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set contest_id
     *
     * @param integer $contestId
     * @return Articles
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
     * Set category_id
     *
     * @param integer $categoryId
     * @return Articles
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
     * Set article
     *
     * @param string $article
     * @return Articles
     */
    public function setArticle($article) {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle() {
        return $this->article;
    }

    /**
     * Set short_description
     *
     * @param string $shortDescription
     * @return Articles
     */
    public function setShortDescription($shortDescription) {
        $this->short_description = $shortDescription;

        return $this;
    }

    /**
     * Get short_description
     *
     * @return string 
     */
    public function getShortDescription() {
        return $this->short_description;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Articles
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set ordering
     *
     * @param integer $ordering
     * @return Articles
     */
    public function setOrdering($ordering) {
        $this->ordering = $ordering;

        return $this;
    }

    /**
     * Get ordering
     *
     * @return integer 
     */
    public function getOrdering() {
        return $this->ordering;
    }

    /**
     * Set has_comment
     *
     * @param integer $hasComment
     * @return Articles
     */
    public function setHasComment($hasComment) {
        $this->has_comment = $hasComment;

        return $this;
    }

    /**
     * Get has_comment
     *
     * @return integer 
     */
    public function getHasComment() {
        return $this->has_comment;
    }

    /**
     * Set has_opinion
     *
     * @param integer $hasOpinion
     * @return Articles
     */
    public function setHasOpinion($hasOpinion) {
        $this->has_opinion = $hasOpinion;

        return $this;
    }

    /**
     * Get has_opinion
     *
     * @return integer 
     */
    public function getHasOpinion() {
        return $this->has_opinion;
    }

    /**
     * Set point_counted
     *
     * @param integer $pointCounted
     * @return Articles
     */
    public function setPointCounted($pointCounted) {
        $this->point_counted = $pointCounted;

        return $this;
    }

    /**
     * Get point_counted
     *
     * @return integer 
     */
    public function getPointCounted() {
        return $this->point_counted;
    }

    /**
     * Set publish_up
     *
     * @param \DateTime $publishUp
     * @return Articles
     */
    public function setPublishUp($publishUp) {
        $this->publish_up = $publishUp;

        return $this;
    }

    /**
     * Get publish_up
     *
     * @return \DateTime 
     */
    public function getPublishUp() {
        return $this->publish_up;
    }

    /**
     * Set publish_down
     *
     * @param \DateTime $publishDown
     * @return Articles
     */
    public function setPublishDown($publishDown) {
        $this->publish_down = $publishDown;

        return $this;
    }

    /**
     * Get publish_down
     *
     * @return \DateTime 
     */
    public function getPublishDown() {
        return $this->publish_down;
    }

    /**
     * Set contest_start_date
     *
     * @param \DateTime $contestStartDate
     * @return Articles
     */
    public function setContestStartDate($contestStartDate) {
        $this->contest_start_date = $contestStartDate;

        return $this;
    }

    /**
     * Get contest_start_date
     *
     * @return \DateTime 
     */
    public function getContestStartDate() {
        return $this->contest_start_date;
    }

    /**
     * Set contest_end_date
     *
     * @param \DateTime $contestEndDate
     * @return Articles
     */
    public function setContestEndDate($contestEndDate) {
        $this->contest_end_date = $contestEndDate;

        return $this;
    }

    /**
     * Get contest_end_date
     *
     * @return \DateTime 
     */
    public function getContestEndDate() {
        return $this->contest_end_date;
    }

    /**
     * Set contest_season
     *
     * @param integer $contestSeason
     * @return Articles
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
     * Set contest_closed
     *
     * @param integer $contestClosed
     * @return Articles
     */
    public function setContestClosed($contestClosed) {
        $this->contest_closed = $contestClosed;

        return $this;
    }

    /**
     * Get contest_closed
     *
     * @return integer 
     */
    public function getContestClosed() {
        return $this->contest_closed;
    }

    /**
     * Set point_accumulated
     *
     * @param integer $pointAccumulated
     * @return Articles
     */
    public function setPointAccumulated($pointAccumulated) {
        $this->point_accumulated = $pointAccumulated;

        return $this;
    }

    /**
     * Get point_accumulated
     *
     * @return integer 
     */
    public function getPointAccumulated() {
        return $this->point_accumulated;
    }

    /**
     * Set total_points
     *
     * @param integer $totalPoints
     * @return Articles
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
     * Set published
     *
     * @param integer $published
     * @return Articles
     */
    public function setPublished($published) {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return integer 
     */
    public function getPublished() {
        return $this->published;
    }

    /**
     * Set moderated
     *
     * @param integer $moderated
     * @return Articles
     */
    public function setModerated($moderated) {
        $this->moderated = $moderated;

        return $this;
    }

    /**
     * Get moderated
     *
     * @return integer 
     */
    public function getModerated() {
        return $this->moderated;
    }

    /**
     * Set featured
     *
     * @param integer $featured
     * @return Articles
     */
    public function setFeatured($featured) {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get featured
     *
     * @return integer 
     */
    public function getFeatured() {
        return $this->featured;
    }

    /**
     * Set social_share
     *
     * @param integer $socialShare
     * @return Articles
     */
    public function setSocialShare($socialShare) {
        $this->social_share = $socialShare;

        return $this;
    }

    /**
     * Get social_share
     *
     * @return integer 
     */
    public function getSocialShare() {
        return $this->social_share;
    }

    /**
     * Set hit
     *
     * @param integer $hit
     * @return Articles
     */
    public function setHit($hit) {
        $this->hit = $hit;

        return $this;
    }

    /**
     * Get hit
     *
     * @return integer 
     */
    public function getHit() {
        return $this->hit;
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

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate() {
        // Add your code here
    }

}
