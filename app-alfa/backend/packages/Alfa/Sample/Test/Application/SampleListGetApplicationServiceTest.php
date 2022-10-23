<?php
declare(strict_types=1);

namespace Alfa\Sample\Test\Application;

use Alfa\Sample\Application\SampleListGetApplicationService;
use Alfa\Sample\Application\SampleListGetCommand;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\Sample;
use Alfa\Sample\Domain\Model\SampleId;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleListGetApplicationServiceTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface|\Alfa\Sample\Domain\Model\ISampleRepository
     */
    private $mockSampleRepository;

    /**
     * @var \Alfa\Sample\Application\SampleListGetApplicationService
     */
    private $applicationService;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockSampleRepository = Mockery::mock(ISampleRepository::class);
        $this->applicationService = new SampleListGetApplicationService(
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
        $command = new SampleListGetCommand();

        $sampleId1 = SampleId::newId();
        $sampleId2 = SampleId::newId();
        $expectedSamples = [
            new Sample($sampleId1, 'タイトル1', '内容1です。'),
            new Sample($sampleId2, 'タイトル2', '内容2です。'),
        ];

        // Expect
        $this->mockSampleRepository->shouldReceive('findAll')
            ->andReturn($expectedSamples)
            ->once();

        // Act
        $result = $this->applicationService->handle($command);

        // Assert
        $this->assertEquals(count($expectedSamples), count($result->samples));
        $this->assertEquals($expectedSamples[0]->getSampleId()->asString(), $result->samples[0]->sampleId);
        $this->assertEquals($expectedSamples[1]->getTitle(), $result->samples[1]->title);
    }
}
