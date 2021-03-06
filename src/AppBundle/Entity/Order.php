<?php

namespace AppBundle\Entity;

use AppBundle\Manager\OrderManager;
use AppBundle\Services\PaymentService;
use datetime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as MyAssert;

/**
 * Order
 *
 * @ORM\Table(name="louvre_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 * @MyAssert\FullQteBooking()
 * @MyAssert\HalfDay()
 *
 */
class Order
{
    const MAX_TICKET_PER_DAY = 1000;
    const HALF_DAY_HOUR_LIMIT = 14;
    const TYPE_FULL_DAY = "jour plein";
    const TYPE_HALF_DAY = "demi-journée";

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
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(name="bookingDate", type="datetime")
     * @Assert\Range(min ="midnight",minMessage="Nous ne proposons pas de voyage dans le temps, veuillez celectionner une date valide")
     * @MyAssert\NotTuesday()
     * @MyAssert\PublicHoliday()
     * @MyAssert\NotSunday()
     *
     *
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
     * @var string
     * @ORM\Column(name="mail", type="string", length=255, unique=false)
     */
    private $mail;
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ticket", mappedBy="order", cascade={"persist"})
     */
    private $tickets;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->setCreatedAt(new datetime());
       // $this->setBookingNumber(md5(random_bytes(10)));
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
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * Get bookingDate
     *
     * @return DateTime
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
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
     * Get qteOrder
     *
     * @return integer
     */
    public function getQteOrder()
    {
        return $this->qteOrder;
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
     * Get typeOrder
     *
     * @return string
     */
    public function getTypeOrder()
    {
        return $this->typeOrder;
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
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
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
     * Get bookingNumber
     *
     * @return string
     */
    public function getBookingNumber()
    {
        return $this->bookingNumber;
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
     * Add ticket
     *
     * @param Ticket $ticket
     *
     * @return Order
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
        $ticket->setOrder($this);
        return $this;
    }

    /**
     * Remove ticket
     *
     * @param Ticket $ticket
     */
    public function removeTicket(Ticket $ticket)
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

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Order
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }
}
