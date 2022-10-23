<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\Sample;

use Alfa\Sample\Application\SamplePostApplicationService;
use Alfa\Sample\Application\SamplePostCommand;
use Alfa\Sample\Application\SamplePostResult;
use Alfa\Sample\Domain\Model\SampleId;
use Cake\Core\Configure;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Mockery;

class SamplePostControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @var \Alfa\Sample\Application\SamplePostApplicationService
     */
    private $mockApplicationService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApplicationService = Mockery::mock(SamplePostApplicationService::class);
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
        $data = [
            'title' => 'タイトル',
            'content' => '内容です',
        ];

        $sampleId = SampleId::newId();
        $result = new SamplePostResult(
            $sampleId->asString()
        );

        $expected = json_encode([
            'data' => [
                'sample_id' => $sampleId->asString(),
            ],
        ], JSON_PRETTY_PRINT);

        // Expect
        $this->mockApplicationService->shouldReceive('handle')
            ->with(
                Mockery::on(function (SamplePostCommand $command) use ($data) {
                    return $command->title === $data['title']
                        && $command->content === $data['content'];
                })
            )
            ->andReturn($result)
            ->once();
        Configure::write('Mock.SamplePostApplicationService', $this->mockApplicationService);

        // Act
        $this->post('/api/sample', $data);

        // Assert
        $this->assertResponseOk();
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }
}
