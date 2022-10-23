<?php
declare(strict_types=1);

namespace Alfa\Sample\Application;

use Alfa\Common\Domain\Model\RecordNotFoundException;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\SampleId;

class SampleGetApplicationService
{
    /**
     * @param \Alfa\Sample\Domain\Model\ISampleRepository $sampleRepository sampleRepository
     */
    public function __construct(
        private ISampleRepository $sampleRepository
    ) {
    }

    /**
     * @param \Alfa\Sample\Application\SampleGetCommand $command command
     * @return \Alfa\Sample\Application\SampleGetResult
     */
    public function handle(SampleGetCommand $command): SampleGetResult
    {
        $sampleId = new SampleId($command->sampleId);

        $sample = $this->sampleRepository->findById($sampleId);
        if (!$sample) {
            throw new RecordNotFoundException("[{$sampleId}] samples record not found");
        }

        return new SampleGetResult(
            $sample->getSampleId()->asString(),
            $sample->getTitle(),
            $sample->getContent()
        );
    }
}
