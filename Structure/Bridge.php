<?php

/**
 * 创建格式化接口。
 */
interface FormatterInterface
{
    public function format(string $text);
}


/**
 * 创建 PlainTextFormatter 文本格式类实现 FormatterInterface 接口。
 */
class PlainTextFormatter implements FormatterInterface
{

    /**
     * 返回字符串格式。
     */
    public function format(string $text)
    {
        return $text;
    }
}


/**
 * 创建 HtmlFormatter HTML 格式类实现 FormatterInterface 接口。
 */
class HtmlFormatter implements FormatterInterface
{

    /**
     * 返回 HTML 格式。
     */
    public function format(string $text)
    {
        return sprintf('<p>%s</p>', $text);
    }
}


/**
 * 创建抽象类 Service。
 */
abstract class Service
{
    /**
     * @var FormatterInterface
     * 定义实现属性。
     */
    protected $implementation;

    /**
     * @param FormatterInterface $printer
     * 传入 FormatterInterface 实现类对象。
     */
    public function __construct(FormatterInterface $printer)
    {
        $this->implementation = $printer;
    }

    /**
     * @param FormatterInterface $printer
     * 和构造方法的作用相同。
     */
    public function setImplementation(FormatterInterface $printer)
    {
        $this->implementation = $printer;
    }

    /**
     * 创建抽象方法 get() 。
     */
    abstract public function get();
}


/**
 * 创建 Service 子类 HelloWorldService 。
 */
class HelloWorldService extends Service
{

    /**
     * 定义抽象方法 get() 。
     * 根据传入的格式类定义来格式化输出 'Hello World' 。
     */
    public function get()
    {
        return $this->implementation->format('Hello World');
    }
}

$service = new HelloWorldService(new PlainTextFormatter());
var_dump('Hello World' === $service->get());

// 现在更改实现方法为使用 HTML 格式器。
$service->setImplementation(new HtmlFormatter());
var_dump('<p>Hello World</p>' === $service->get());