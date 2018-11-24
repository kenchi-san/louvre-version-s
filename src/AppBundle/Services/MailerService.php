<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 30/10/2018
 * Time: 15:09
 */

namespace AppBundle\Services;


use AppBundle\Entity\ContactUs;
use AppBundle\Entity\Order;
use Twig\Environment;

class MailerService
{

    private $louvreMail;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct($louvreMail, Environment $twig, \Swift_Mailer $mailer)
    {
        $this->louvreMail = $louvreMail;
        $this->twig = $twig;
        $this->mailer = $mailer;
    }


    public function sendOrderConfirmation(Order $order){
        $mail = new \Swift_Message("Confirmation de votre commande");
        $mail->setFrom($this->louvreMail);
        $mail->setTo($order->getMail());
        $urlLogo = $mail->embed(\Swift_Image::fromPath('img/logo-louvre.jpg'));

            $mail->setBody($this->twig->render('email/confirmationBooking.html.twig', ['logo' => $urlLogo,'confirmationMail'=>$order]), 'text/html');



        $this->mailer->send($mail);


    }

    public function sendTheQuestionByMail(ContactUs $contactUs){
        $mail = new \Swift_Message("Demande Client");
        $mail->setFrom($contactUs->getMail());
        $mail->setTo($this->louvreMail);
        $urlLogo = $mail->embed(\Swift_Image::fromPath('img/logo-louvre.jpg'));

        $mail->setBody($this->twig->render('email/GuestQuestion.html.twig', ['logo' => $urlLogo,'GuestQuestion'=>$contactUs]), 'text/html');



        $this->mailer->send($mail);
    }

}
