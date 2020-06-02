<?php

class Facade
{
    /**
     * @var OsInterface
     * 定义操作系统接口变量。
     */
    private $os;

    /**
     * @var BiosInterface
     * 定义基础输入输出系统接口变量。
     */
    private $bios;

    /**
     * @param BiosInterface $bios
     * @param OsInterface $os
     * 传入基础输入输出系统接口对象 $bios 。
     * 传入操作系统接口对象 $os 。
     */
    public function __construct(BiosInterface $bios, OsInterface $os)
    {
        $this->bios = $bios;
        $this->os = $os;
    }

    /**
     * 构建基础输入输出系统执行启动方法。
     */
    public function turnOn()
    {
        $this->bios->execute();
        $this->bios->waitForKeyPress();
        $this->bios->launch($this->os);
    }

    /**
     * 构建系统关闭方法。
     */
    public function turnOff()
    {
        $this->os->halt();
        $this->bios->powerDown();
    }
}

/**
 * 创建操作系统接口类 OsInterface 。
 */
interface OsInterface
{
    /**
     * 声明关机方法。
     */
    public function halt();

    /**
     * 声明获取名称方法，返回字符串格式数据。
     */
    public function getName(): string;
}

/**
 * 创建基础输入输出系统接口类 BiosInterface 。
 */
interface  BiosInterface
{
    /**
     * 声明执行方法。
     */
    public function execute();

    /**
     * 声明等待密码输入方法
     */
    public function waitForKeyPress();

    /**
     * 声明登录方法。
     */
    public function launch(OsInterface $os);

    /**
     * 声明关机方法。
     */
    public function powerDown();
}

