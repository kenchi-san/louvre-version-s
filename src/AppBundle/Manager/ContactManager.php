<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 24/11/2018
 * Time: 01:14
 */

namespace AppBundle\Manager;


use AppBundle\Entity\ContactUs;
use AppBundle\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager
{
    /**
     * @var MailerService
     */
    private $mailer;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    /**
     * ContactManager constructor.
     * @param MailerService $mailer
     * @param EntityManagerInterface $em
     */
    public function __construct(MailerService $mailer, EntityManagerInterface $em)
    {

        $this->mailer = $mailer;
        $this->em = $em;
    }

    public function initContact()
    {
        $contactUs = new ContactUs();
        return $contactUs;
    }

    public function sendTheMailFromGuest(ContactUs $contactUs){
        $this->em->persist($contactUs);
        $this->em->flush();
        $this->mailer->sendTheQuestionByMail($contactUs);
    }
}