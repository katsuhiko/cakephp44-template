<?php
declare(strict_types=1);

namespace Alfa\Sample\Application;

use Alfa\Common\Application\ITransaction;
use Alfa\Common\Domain\Model\TransactionException;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\Sample;
use Alfa\Sample\Domain\Model\SampleId;

class SamplePutApplicationService
{
    /**
     * @param \Alfa\Common\Application\ITransaction $transaction transaction
     * @param \Alfa\Sample\Domain\Model\ISampleRepository $sampleRepository sampleRepository
     */
    public function __construct(
        private ITransaction $transaction,
        private ISampleRepository $sampleRepository
    ) {
    }

    /**
     * @param \Alfa\Sample\Application\SamplePutCommand $command command
     * @return \Alfa\Sample\Application\SamplePutResult
     */
    public function handle(SamplePutCommand $command): SamplePutResult
    {
        $sampleId = new SampleId($command->sampleId);

        $sample = new Sample(
            $sampleId,
            $command->title,
            $command->content
        );

        $this->transaction->transactional(function () use ($sample) {
            $result = $this->sampleRepository->update($sample);
            if (!$result) {
                throw new TransactionException("[{$sample->getSampleId()}] samples 更新できませんでした。");
            }

            return true;
        });

        return new SamplePutResult();
    }
}
