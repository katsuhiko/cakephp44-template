<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Sample;

use Alfa\Sample\Application\SamplePutApplicationService;
use Alfa\Sample\Application\SamplePutCommand;
use Alfa\Sample\Application\SamplePutResult;
use Alfa\Sample\Domain\Model\SampleId;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Mockery;

class SamplePutControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var \Alfa\Sample\Application\SamplePutApplicationService
     */
    private $mockApplicationService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplicationService = Mockery::mock(SamplePutApplicationService::class);
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
     * @test
     * @return void
     */
    public function testHandle(): void
    {
        // Arrange
        $sampleId = SampleId::newId();
        $data = [
            'title' => 'タイトル',
            'content' => '内容です',
        ];

        $result = new SamplePutResult(
        );

        $expected = json_encode([
            'data' => [],
        ], JSON_PRETTY_PRINT);

        // Expect
        $this->mockApplicationService->shouldReceive('handle')
            ->with(
                Mockery::on(function (SamplePutCommand $command) use ($sampleId, $data) {
                    return $command->sampleId === $sampleId->asString()
                        && $command->title === $data['title']
                        && $command->content === $data['content'];
                })
            )
            ->andReturn($result)
            ->once();
        Configure::write('Mock.SamplePutApplicationService', $this->mockApplicationService);

        // Act
        $this->put("/api/sample/{$sampleId->asString()}", $data);

        // Assert
        $this->assertResponseOk();
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * @test
     * @return void
     */
    public function testHandle_ValidationError(): void
    {
        // Arrange
        $sampleId = SampleId::newId();
        $data = [
            'content' => '内容です',
        ];

        $expected = json_encode([
            'errors' => [
                [
                    'code' => '_required',
                    'source' => [
                        'pointer' => '/title',
                    ],
                    'title' => 'This field is required',
                ],
            ],
        ], JSON_PRETTY_PRINT);

        // Expect
        $this->mockApplicationService->shouldReceive('handle')
            ->never();
        Configure::write('Mock.SamplePutApplicationService', $this->mockApplicationService);

        // Act
        $this->put("/api/sample/{$sampleId->asString()}", $data);

        // Assert
        $this->assertResponseCode(400);
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }
}
