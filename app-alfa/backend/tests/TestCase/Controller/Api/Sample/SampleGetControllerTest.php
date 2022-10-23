<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Sample;

use Alfa\Sample\Application\SampleGetApplicationService;
use Alfa\Sample\Application\SampleGetCommand;
use Alfa\Sample\Application\SampleGetResult;
use Alfa\Sample\Domain\Model\SampleId;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Mockery;

class SampleGetControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var \Alfa\Sample\Application\SampleGetApplicationService
     */
    private $mockApplicationService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplicationService = Mockery::mock(SampleGetApplicationService::class);
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
        $result = new SampleGetResult(
            $sampleId->asString(),
            'タイトル',
            '内容です。'
        );

        $expected = json_encode([
            'data' => [
                'sample_id' => $sampleId->asString(),
                'title' => 'タイトル',
                'content' => '内容です。',
            ],
        ], JSON_PRETTY_PRINT);

        // Expect
        $this->mockApplicationService->shouldReceive('handle')
            ->with(
                Mockery::on(function (SampleGetCommand $command) use ($sampleId) {
                    return $command->sampleId === $sampleId->asString();
                })
            )
            ->andReturn($result)
            ->once();
        Configure::write('Mock.SampleGetApplicationService', $this->mockApplicationService);

        // Act
        $this->get("/api/sample/{$sampleId->asString()}");

        // Assert
        $this->assertResponseOk();
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }
}
