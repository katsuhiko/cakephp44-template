<?php
declare(strict_types=1);

namespace Alfa\Sample\Test\Application;

use Alfa\Common\Test\Application\TestTransaction;
use Alfa\Common\Domain\Model\TransactionException;
use Alfa\Sample\Application\SampleDeleteApplicationService;
use Alfa\Sample\Application\SampleDeleteCommand;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\SampleId;
use Mockery;
use PHPUnit\Framework\TestCase;

class SampleDeleteApplicationServiceTest extends TestCase
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
     * @var \Alfa\Sample\Application\SampleDeleteApplicationService
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
        $this->applicationService = new SampleDeleteApplicationService(
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
        $command = new SampleDeleteCommand(
            $sampleId->asString()
        );

        // Expect
        $this->mockSampleRepository->shouldReceive('remove')
            ->once()
            ->with(
                Mockery::on(function (SampleId $sampleId) use ($command) {
                    return $sampleId->asString() === $command->sampleId;
                })
            )
            ->andReturn(true);

        // Act
        $result = $this->applicationService->handle($command);

        // Assert
        $this->assertNotNull($result);
    }

    /**
     * @test
     * @return void
     */
    public function testHandle_IfDeleteFails_ThrowAnException(): void
    {
        // Arrange
        $sampleId = SampleId::newId();
        $command = new SampleDeleteCommand(
            $sampleId->asString()
        );

        // Expect
        $this->expectException(TransactionException::class);

        $this->mockSampleRepository->shouldReceive('remove')
            ->once()
            ->andReturn(false);

        // Act
        $result = $this->applicationService->handle($command);
    }}
