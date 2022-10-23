<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Sample;

use Alfa\Sample\Application\SampleDeleteApplicationService;
use Alfa\Sample\Application\SampleDeleteCommand;
use Alfa\Sample\Application\SampleDeleteResult;
use Alfa\Sample\Domain\Model\SampleId;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Mockery;

class SampleDeleteControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var \Alfa\Sample\Application\SampleDeleteApplicationService
     */
    private $mockApplicationService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplicationService = Mockery::mock(SampleDeleteApplicationService::class);
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * @return void
     */
    public function testHandle(): void
    {
        // Arrange
        $sampleId = SampleId::newId();
        $result = new SampleDeleteResult(
        );

        $expected = json_encode([
            'data' => [],
        ], JSON_PRETTY_PRINT);

        // Expect
        $this->mockApplicationService->shouldReceive('handle')
            ->with(
                Mockery::on(function (SampleDeleteCommand $command) use ($sampleId) {
                    return $command->sampleId === $sampleId->asString();
                })
            )
            ->andReturn($result)
            ->once();
        Configure::write('Mock.SampleDeleteApplicationService', $this->mockApplicationService);

        // Act
        $this->delete("/api/sample/{$sampleId->asString()}");

        // Assert
        $this->assertResponseOk();
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }
}
