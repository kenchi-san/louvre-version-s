<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{


    /**
     * @dataProvider ulrsProvider
     * @param $url
     * @param $statusExpected
     */
    public function testUlrs($url, $statusExpected)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals($statusExpected, $client->getResponse()->getStatusCode());
    }


    public function ulrsProvider()
    {
        return [
            ['/', 200],
            ['/booking', 200],
            ['/etape-2', 404],
            ['/etape-3', 404],
            ['/etape-4', 404],
            ['/contact', 200],

        ];
    }

    public function testTakeOrderUntilTheEnd()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $link = $crawler->selectLink('réservation')->link();
        $crawler = $client->click($link);

        $this->assertContains('/booking', $client->getRequest()->getRequestUri());

        $form = $crawler->selectButton('Etape suivante:')->form();
        $form['appbundle_initorder[bookingDate]'] = "2019-09-2";
        $form['appbundle_initorder[qteOrder]'] = 1;
        $form['appbundle_initorder[typeOrder]'] = 'jour plein';
        $form['appbundle_initorder[mail]'] = 'bibi@hotmail.fr';
        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());

        $crawler = $client->followRedirect();

        $form = $crawler->selectButton('sauvegarder votre réservation:')->form();
        $form ['appbundle_order[tickets][0][firstname]'] = 'jean';
        $form ['appbundle_order[tickets][0][lastname]'] = 'paul';
        $form ['appbundle_order[tickets][0][country]'] = 'FR';
        $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());

        $scrawler = $client->followRedirect();



    }
}
