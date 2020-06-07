<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__.'/../Visitor.php';

class VisitorTest extends TestCase
{
    /**
     * @var Visitor\RoleVisitor
     */
    private $visitor;

    protected function setUp()
    {
        $this->visitor = new RoleVisitor();
    }

    public function provideRoles()
    {
        return [
            [new User('Dominik')],
            [new Group('Administrators')],
        ];
    }

    /**
     * @dataProvider provideRoles
     *
     * @param Visitor\Role $role
     */
    public function testVisitSomeRole(Role $role)
    {
        $role->accept($this->visitor);
        $this->assertSame($role, $this->visitor->getVisited()[0]);
    }
}