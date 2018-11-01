<?php
/**
 * Created by PhpStorm.
 * User: charo
 * Date: 30/10/2018
 * Time: 15:09
 */

namespace AppBundle\Services;


use AppBundle\Entity\Order;
use Twig\Environment;

class MailerService
{

    private $louvreMail;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct($louvreMail, Environment $twig)
    {
        $this->louvreMail = $louvreMail;
        $this->twig = $twig;
    }


    public function sendOrderConfirmation(Order $order){
        $mail = new \Swift_Message("Confirmation de votre commande");
        $mail->setFrom($this->louvreMail);
        $mail->setTo($order->getMail());
        $urlLogo = $mail->embed(\Swift_Image::fromPath('img/logo-louvre.jpg'));
        $mail->setBody($this->twig->render('email/confirmationBooking.html.twig', ['logo' => $urlLogo]), 'text/html');


        //$swift_Mailer->send($mail);
    }

}