<?php

namespace AppBundle\Entity;

use datetime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Order
 *
 * @ORM\Table(name="order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 *
 */
class Order
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
     * @var DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", unique=true)
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="bookingDate", type="datetime")
     */
    private $bookingDate;

    /**
     * @var int
     * @ORM\Column(name="qteOrder", type="integer")
     * @Assert\Length(min="1",minMessage="Vous devez mettre au moins une personne pour faire votre réservation", max="3",maxMessage="La capacité pour les visites ne peux excéder {{limit}} personnes")
     */
    private $qteOrder;

    /**
     * @var string
     *
     * @ORM\Column(name="TypeOrder", type="string", length=255)
     */
    private $typeOrder;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="bookingNumber", type="string", length=255, unique=true)
     */
    private $bookingNumber;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="order")
     */
    private $tickets;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->setCreatedAt(new datetime()) ;
        $this->bookingNumber= md5(random_bytes(10));
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return Order
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set bookingDate
     *
     * @param DateTime $bookingDate
     *
     * @return Order
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return DateTime
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * Set qteOrder
     *
     * @param integer $qteOrder
     *
     * @return Order
     */
    public function setQteOrder($qteOrder)
    {
        $this->qteOrder = $qteOrder;

        return $this;
    }

    /**
     * Get qteOrder
     *
     * @return integer
     */
    public function getQteOrder()
    {
        return $this->qteOrder;
    }

    /**
     * Set typeOrder
     *
     * @param string $typeOrder
     *
     * @return Order
     */
    public function setTypeOrder($typeOrder)
    {
        $this->typeOrder = $typeOrder;

        return $this;
    }

    /**
     * Get typeOrder
     *
     * @return string
     */
    public function getTypeOrder()
    {
        return $this->typeOrder;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Order
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set bookingNumber
     *
     * @param string $bookingNumber
     *
     * @return Order
     */
    public function setBookingNumber($bookingNumber)
    {
        $this->bookingNumber = $bookingNumber;

        return $this;
    }

    /**
     * Get bookingNumber
     *
     * @return string
     */
    public function getBookingNumber()
    {
        return $this->bookingNumber;
    }

    /**
     * Add ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     *
     * @return Order
     */
    public function addTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        return $this;
    }

    /**
     * Remove ticket
     *
     * @param \AppBundle\Entity\Ticket $ticket
     */
    public function removeTicket(\AppBundle\Entity\Ticket $ticket)
    {
        $this->tickets->removeElement($ticket);
    }

    /**
     * Get tickets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTickets()
    {
        return $this->tickets;
    }


}
