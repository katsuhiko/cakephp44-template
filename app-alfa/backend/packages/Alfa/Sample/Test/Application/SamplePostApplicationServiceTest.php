<?php
declare(strict_types=1);

namespace Alfa\Sample\Test\Application;

use Alfa\Common\Test\Application\TestTransaction;
use Alfa\Sample\Application\SamplePostApplicationService;
use Alfa\Sample\Application\SamplePostCommand;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\Sample;
use Alfa\Sample\Domain\Model\SampleId;
use Mockery;
use PHPUnit\Framework\TestCase;

class SamplePostApplicationServiceTest extends TestCase
{
    /**
     * @var \Alfa\Common\Application\ITransaction
     */
    private $testTransaction;

    /**
     * @var \Mockery\MockInterface|\Alfa\Sample\Domain\Model\ISampleRepository
     */
    private $mockSampleRepository;

    /**
     * @var \Alfa\Sample\Application\SamplePostApplicationService
     */
    private $applicationService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->testTransaction = new TestTransaction();
        $this->mockSampleRepository = Mockery::mock(ISampleRepository::class);
        $this->applicationService = new SamplePostApplicationService(
            $this->testTransaction,
            $this->mockSampleRepository
        );
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
        $command = new SamplePostCommand(
            'タイトル',
            '内容です。'
        );

        // Expect
        $this->mockSampleRepository->shouldReceive('save')
            ->with(
                Mockery::on(function (Sample $sample) use ($command) {
                    return $sample->getTitle() === $command->title
                        && $sample->getContent() === $command->content;
                })
            )
            ->andReturn(true)
            ->once();

        // Act
        $result = $this->applicationService->handle($command);

        // Assert
        $this->assertNotNull($result->sampleId);
    }
}
