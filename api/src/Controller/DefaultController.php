<?php
namespace App\Controller;

use App\Entity\Parse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Message\RedisMessage;

class DefaultController extends AbstractController
{
    public function index(Request $request, MessageBusInterface $bus): Response
    {

//        $content = file_get_contents('https://stackoverflow.com/questions/23062537/how-to-convert-html-to-json-using-php');
//        $dom = new \DOMDocument();
//        @$dom->loadHTML($content);
//        foreach($dom->getElementsByTagName('*') as $el){
//            $result[] = $el->tagName;
//        }
//
//        print_r("<pre>");
//        print_r(array_count_values($result));
//        print_r("</pre>");
//        $this->dispatchMessage(new RedisMessage('Look! I created a message!'));
//        $bus->dispatch(new RedisMessage());


        return $this->render('welcome.html.twig');
    }

    public function tags(Request $request, MessageBusInterface $bus): Response
    {
        $url = $request->request->get('url');


        $entityManager = $this->getDoctrine()->getManager();
        $parse = new Parse();
        $parse->setUrl($url);
        $entityManager->persist($parse);
        $entityManager->flush();

        $bus->dispatch(new RedisMessage($url, $parse->getId()));

        $response = 'задание добавили c id: '. $parse->getId();
//        $response = 'ку епта, задание не получилось добавить';

        return $this->render('tags.html.twig', [
            'response' => $response,
        ]);
    }

    public function tagsId(string $id): Response
    {
        $parse = $this->getDoctrine()
            ->getRepository(Parse::class)
            ->find((int) $id);
        if (empty($parse->getData())) {
            throw new \Error('еще не готово задание');
//            throw new \Error('нет такого задания');
        }

        $result = $parse->data;

        return $this->render('tags.html.twig', [
            'result' => $result,
        ]);
    }
}