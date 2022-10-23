<?php
declare(strict_types=1);

namespace Alfa\Sample\Application;

use Alfa\Sample\Domain\Model\ISampleRepository;

class SampleListGetApplicationService
{
    /**
     * @param \Alfa\Sample\Domain\Model\ISampleRepository $sampleRepository sampleRepository
     */
    public function __construct(
        private ISampleRepository $sampleRepository
    ) {
    }

    /**
     * @param \Alfa\Sample\Application\SampleListGetCommand $command command
     * @return \Alfa\Sample\Application\SampleListGetResult
     */
    public function handle(SampleListGetCommand $command): SampleListGetResult
    {
        $samples = $this->sampleRepository->findAll();

        /** @var \Alfa\Sample\Application\SampleResult[] $sampleResult */
        $sampleResult = [];
        foreach ($samples as $sample) {
            $sampleResult[] = new SampleResult(
                $sample->getSampleId()->asString(),
                $sample->getTitle(),
                $sample->getContent()
            );
        }

        return new SampleListGetResult(
            $sampleResult
        );
    }
}
