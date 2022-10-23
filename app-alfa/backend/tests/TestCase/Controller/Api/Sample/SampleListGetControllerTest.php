<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Sample;

use Alfa\Sample\Application\SampleListGetApplicationService;
use Alfa\Sample\Application\SampleListGetCommand;
use Alfa\Sample\Application\SampleListGetResult;
use Alfa\Sample\Application\SampleResult;
use Alfa\Sample\Domain\Model\SampleId;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Mockery;

class SampleListGetControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var \Alfa\Sample\Application\SampleListGetApplicationService
     */
    private $mockApplicationService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplicationService = Mockery::mock(SampleListGetApplicationService::class);
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
        $sampleId1 = SampleId::newId();
        $sampleId2 = SampleId::newId();
        $result = new SampleListGetResult([
            new SampleResult($sampleId1->asString(), 'タイトル1', '内容1です。'),
            new SampleResult($sampleId2->asString(), 'タイトル2', '内容2です。'),
        ]);

        $expected = json_encode([
            'data' => [
                [ 'sample_id' => $sampleId1->asString(), 'title' => 'タイトル1', 'content' => '内容1です。'],
                [ 'sample_id' => $sampleId2->asString(), 'title' => 'タイトル2', 'content' => '内容2です。'],
            ],
        ], JSON_PRETTY_PRINT);

        // Expect
        $this->mockApplicationService->shouldReceive('handle')
            ->once()
            ->with(
                Mockery::on(function (SampleListGetCommand $command) {
                    return true;
                })
            )
            ->andReturn($result);
        Configure::write('Mock.SampleListGetApplicationService', $this->mockApplicationService);

        // Act
        $this->get('/api/sample');

        // Assert
        $this->assertResponseOk();
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }
}
