<?php
declare(strict_types=1);

namespace Alfa\Sample\Test\Application;

use Alfa\Common\Domain\Model\RecordNotFoundException;
use Alfa\Sample\Application\SampleGetApplicationService;
use Alfa\Sample\Application\SampleGetCommand;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\Sample;
use Alfa\Sample\Domain\Model\SampleId;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleGetApplicationServiceTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface|\Alfa\Sample\Domain\Model\ISampleRepository
     */
    private $mockSampleRepository;

    /**
     * @var \Alfa\Sample\Application\SampleGetApplicationService
     */
    private $applicationService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockSampleRepository = Mockery::mock(ISampleRepository::class);
        $this->applicationService = new SampleGetApplicationService(
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
        $command = new SampleGetCommand(
            $sampleId->asString()
        );

        $expectedSample = new Sample(
            $sampleId,
            'タイトル',
            '内容です。'
        );

        // Expect
        $this->mockSampleRepository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (SampleId $sampleId) use ($command) {
                    return $sampleId->asString() === $command->sampleId;
                })
            )
            ->andReturn($expectedSample);

        // Act
        $result = $this->applicationService->handle($command);

        // Assert
        $this->assertEquals($expectedSample->getSampleId(), $result->sampleId);
        $this->assertEquals($expectedSample->getTitle(), $result->title);
        $this->assertEquals($expectedSample->getContent(), $result->content);
    }

    /**
     * @test
     * @return void
     */
    public function testHandle_IfRecordIsNotFound_ThrowAnException(): void
    {
        // Arrange
        $sampleId = SampleId::newId();
        $command = new SampleGetCommand(
            $sampleId->asString()
        );

        // Expect
        $this->expectException(RecordNotFoundException::class);

        $this->mockSampleRepository->shouldReceive('findById')
            ->once()
            ->andReturn(null);

        // Act
        $result = $this->applicationService->handle($command);
    }
}
