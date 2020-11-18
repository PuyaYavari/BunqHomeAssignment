<?php declare(strict_types=1);

namespace test\LayerService\Objects;

use \PHPUnit\Framework\TestCase;
use \App\LayerService\Objects\PhavaText;
use Faker;

/**
 * @author Pouya
 */
final class PhavaTextTest extends TestCase
{
    public function testGetTextStringType()
    {
        $faker = Faker\Factory::create();
        $text = $faker->text(1000);
        $phavaTextObject = new PhavaText($text);
        $this->assertIsString($phavaTextObject->getTextString());
    }

    /**
     * @depends testGetTextStringType
     */
    public function testGetTextStringValue()
    {
        $faker = Faker\Factory::create();
        $text = $faker->text(1000);
        $phavaTextObject = new PhavaText($text);
        $this->assertEquals($text, $phavaTextObject->getTextString());
    }
}

?>