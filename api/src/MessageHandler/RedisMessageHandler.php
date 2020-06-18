<?php
namespace App\MessageHandler;

use App\Entity\Parse;
use App\Message\RedisMessage;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RedisMessageHandler implements MessageHandlerInterface
{
    private ?ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function parse(string $url)
    {
        $content = file_get_contents($url);
        $dom = new \DOMDocument();
        @$dom->loadHTML($content);
        foreach($dom->getElementsByTagName('*') as $el){
            $result[] = $el->tagName;
        }

        return \json_encode(array_count_values($result));
    }

    public function __invoke(RedisMessage $message)
    {
        $url = $message->getContent();
        $id = $message->getId();

        $data = $this->parse($url);

        $doc = $this->container->get('doctrine');
        $em = $doc->getManager();
        $parse = $em->getRepository(Parse::class)->find($id);
        $parse->setData($data);
        $em->persist($parse);
        $em->flush();
    }
}