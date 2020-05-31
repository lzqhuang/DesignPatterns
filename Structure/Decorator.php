<?php
/**
 * 为类实例动态增加新的方法。
 */

/**
 * 创建渲染接口。
 * 这里的装饰方法 renderData() 返回的是字符串格式数据。
 */
interface RenderableInterface
{
    public function renderData(): string;
}

/**
 * 创建 Webservice 服务类实现 RenderableInterface。
 * 该类将在后面为装饰者实现数据的输入。
 */
class Webservice implements RenderableInterface
{
    /**
     * @var string
     */
    private $data;

    /**
     * 传入字符串格式数据。
     */
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * 实现 RenderableInterface 渲染接口中的 renderData() 方法。
     * 返回传入的数据。
     */
    public function renderData(): string
    {
        return $this->data;
    }
}

/**
 * 装饰者必须实现渲染接口类 RenderableInterface 契约，这是该设计
 * 模式的关键点。否则，这将不是一个装饰者而只是一个自欺欺人的包
 * 装。
 *
 * 创建抽象类 RendererDecorator （渲染器装饰者）实现渲染接口。
 */
abstract class RendererDecorator implements RenderableInterface
{
    /**
     * @var RenderableInterface
     * 定义渲染接口变量。
     */
    protected $wrapped;

    /**
     * @param RenderableInterface $renderer
     * 传入渲染接口类对象 $renderer。
     */
    public function __construct(RenderableInterface $renderer)
    {
        $this->wrapped = $renderer;
    }
}

/**
 * 创建 Xml 修饰者并继承抽象类 RendererDecorator 。
 */
class XmlRenderer extends RendererDecorator
{

    /**
     * 对传入的渲染接口对象进行处理，生成 DOM 数据文件。
     */
    public function renderData(): string
    {
        $doc = new \DOMDocument();
        $data = $this->wrapped->renderData();
        $doc->appendChild($doc->createElement('content', $data));

        return $doc->saveXML();
    }
}

/**
 * 创建 Json 修饰者并继承抽象类 RendererDecorator 。
 */
class JsonRenderer extends RendererDecorator
{
    /**
     * 对传入的渲染接口对象进行处理，生成 JSON 数据。
     */
    public function renderData(): string
    {
        return json_encode($this->wrapped->renderData());
    }
}

$service = new Webservice('foobar');
$service = new JsonRenderer($this->service);

var_dump('"foobar"'===$service->renderData());
$service = new XmlRenderer($this->service);

var_dump('<?xml version="1.0"?><content>foobar</content>'===$service->renderData());

