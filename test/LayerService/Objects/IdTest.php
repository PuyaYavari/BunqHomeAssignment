<?php declare(strict_types=1);

namespace test\LayerService\Objects;

use \PHPUnit\Framework\TestCase;
use \app\LayerService\Objects\Id;


final class IdTest extends TestCase
{
    public function testGetIdIntType(): void
    {
        $validRandomValue = Rand()+1;
        $id = new Id($validRandomValue);
        $this->assertIsInt($id->getIdInt());
    }

    /**
     * @depends testGetIdIntType
     */
    public function testGetIdIntValue(): void
    {
        $validRandomValue = Rand()+1;
        $id = new Id($validRandomValue);
        $this->assertEquals($validRandomValue, $id->getIdInt());
    }
}

?>