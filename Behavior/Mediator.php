<?php

/**
 * MediatorInterface 接口为 Mediator 类建立契约
 * 该接口虽非强制，但优于 Liskov 替换原则。
 */
interface MediatorInterface
{
    /**
     * 发出响应
     *
     * @param string $content
     */
    public function sendResponse($content);

    /**
     * 做出请求
     */
    public function makeRequest();

    /**
     * 查询数据库
     */
    public function queryDb();
}

/**
 * Mediator 是用于访设计模式的中介者模式的实体
 *
 * 本示例中，我用中介者模式做了一个 “Hello World” 的响应
 */
class Mediator implements MediatorInterface
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var Database
     */
    private $database;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param Database $database
     * @param Client $client
     * @param Server $server
     */
    public function __construct(Database $database, Client $client, Server $server)
    {
        $this->database = $database;
        $this->server = $server;
        $this->client = $client;

        $this->database->setMediator($this);
        $this->server->setMediator($this);
        $this->client->setMediator($this);
    }

    public function makeRequest()
    {
        $this->server->process();
    }

    public function queryDb(): string
    {
        return $this->database->getData();
    }

    /**
     * @param string $content
     */
    public function sendResponse($content)
    {
        $this->client->output($content);
    }
}

/**
 * Colleague 是个抽象类，该类对象虽彼此协同却不知彼此，只知中介者 Mediator 类
 */
abstract class Colleague
{
    /**
     * 确保子类不变化。
     *
     * @var MediatorInterface
     */
    protected $mediator;

    /**
     * @param MediatorInterface $mediator
     */
    public function setMediator(MediatorInterface $mediator)
    {
        $this->mediator = $mediator;
    }
}

/**
 * Client 类是一个发出请求并获得响应的客户端。
 */
class Client extends Colleague
{
    public function request()
    {
        $this->mediator->makeRequest();
    }

    public function output(string $content)
    {
        echo $content;
    }
}

class Database extends Colleague
{
    public function getData(): string
    {
        return 'World';
    }
}

class Server extends Colleague
{
    public function process()
    {
        $data = $this->mediator->queryDb();
        $this->mediator->sendResponse(sprintf("Hello %s", $data));
    }
}

$client = new Client();
new Mediator(new Database(), $client, new Server());

$this->expectOutputString('Hello World');
$client->request();