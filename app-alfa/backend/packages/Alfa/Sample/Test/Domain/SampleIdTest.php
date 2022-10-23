<?php
declare(strict_types=1);

namespace Alfa\Smaple\Test\Domain\Model;

use Alfa\Common\Domain\Model\InvalidArgumentException;
use Alfa\Sample\Domain\Model\SampleId;
use PHPUnit\Framework\TestCase;

class SampleIdTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function testConstructor(): void
    {
        // Arrange
        $expectedId = 'id-1';

        // Act
        $result = new SampleId($expectedId);

        // Assert
        $this->assertEquals($expectedId, $result);
        $this->assertEquals($expectedId, $result->asString());
    }

    /**
     * @test
     * @return void
     */
    // phpcs:ignore
    public function testConstructor_空文字は認めないこと(): void
    {
        // Arrange
        $expectedId = '';

        // Expect
        $this->expectException(InvalidArgumentException::class);

        // Act
        $result = new SampleId($expectedId);
    }

    /**
     * @test
     * @return void
     */
    // phpcs:ignore
    public function testEquals_一致すること(): void
    {
        // Arrange
        $value1 = new SampleId('id-1');
        $value2 = new SampleId('id-1');

        // Act
        $result = $value1->equals($value2);

        // Assert
        $this->assertTrue($result);
    }

    /**
     * @test
     * @return void
     */
    // phpcs:ignore
    public function testEquals_一致しないこと(): void
    {
        // Arrange
        $value1 = new SampleId('id-1');
        $value2 = new SampleId('id-2');

        // Act
        $result = $value1->equals($value2);

        // Assert
        $this->assertFalse($result);
    }
}
