<?php

interface CommandInterface
{
    /**
     * 这是在命令行模式中很重要的方法，
     * 这个接收者会被载入构造器
     */
    public function execute();
}

/**
 * 这个具体命令，在接收器上调用 "print" ，
 *  但是外部调用者只知道，这个是否可以执行。
 */
class HelloCommand implements CommandInterface
{
    /**
     * @var Receiver
     */
    private $output;

    /**
     * 每个具体的命令都来自于不同的接收者。
     * 这个可以是一个或者多个接收者，但是参数里必须是可以被执行的命令。
     *
     * @param Receiver $console
     */
    public function __construct(Receiver $console)
    {
        $this->output = $console;
    }

    /**
     * 执行和输出 "Hello World".
     */
    public function execute()
    {
        // 有时候，这里没有接收者，并且这个命令执行所有工作。
        $this->output->write('Hello World');
    }
}


/**
 * 接收方是特定的服务，有自己的 contract ，只能是具体的实例。
 */
class Receiver
{
    /**
     * @var bool
     */
    private $enableDate = false;

    /**
     * @var string[]
     */
    private $output = [];

    /**
     * @param string $str
     */
    public function write(string $str)
    {
        if ($this->enableDate) {
            $str .= ' [' . date('Y-m-d') . ']';
        }

        $this->output[] = $str;
    }

    public function getOutput(): string
    {
        return join("\n", $this->output);
    }

    /**
     * 可以显示消息的时间
     */
    public function enableDate()
    {
        $this->enableDate = true;
    }

    /**
     * 禁止显示消息的时间
     */
    public function disableDate()
    {
        $this->enableDate = false;
    }
}

/**
 *调用者使用这种命令。
 * 比例 : 一个在 SF2 中的应用
 */
class Invoker
{
    /**
     * @var CommandInterface
     */
    private $command;

    /**
     * 在这种调用者中，我们发现，订阅命令也是这种方法
     * 还包括：堆栈、列表、集合等等
     *
     * @param CommandInterface $cmd
     */
    public function setCommand(CommandInterface $cmd)
    {
        $this->command = $cmd;
    }

    /**
     * 执行这个命令；
     * 调用者也是用这个命令。
     */
    public function run()
    {
        $this->command->execute();
    }
}

$invoker = new Invoker();
$receiver = new Receiver();

$invoker->setCommand(new HelloCommand($receiver));
$invoker->run();
var_dump('Hello World' === $receiver->getOutput());
