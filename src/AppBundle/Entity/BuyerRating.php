<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BuyerRating
 *
 * @ORM\Table(name="buyer_rating")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BuyerRatingRepository")
 */
class BuyerRating
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="buyerId", type="integer")
     */
    private $buyerId;

    /**
     * @var int
     *
     * @ORM\Column(name="sellerId", type="integer")
     */
    private $sellerId;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set buyerId
     *
     * @param integer $buyerId
     *
     * @return BuyerRating
     */
    public function setBuyerId($buyerId)
    {
        $this->buyerId = $buyerId;

        return $this;
    }

    /**
     * Get buyerId
     *
     * @return int
     */
    public function getBuyerId()
    {
        return $this->buyerId;
    }

    /**
     * Set sellerId
     *
     * @param integer $sellerId
     *
     * @return BuyerRating
     */
    public function setSellerId($sellerId)
    {
        $this->sellerId = $sellerId;

        return $this;
    }

    /**
     * Get sellerId
     *
     * @return int
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return BuyerRating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }
}
