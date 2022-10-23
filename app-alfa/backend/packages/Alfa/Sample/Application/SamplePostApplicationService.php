<?php
declare(strict_types=1);

namespace Alfa\Sample\Application;

use Alfa\Common\Application\ITransaction;
use Alfa\Common\Domain\Model\TransactionException;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\Sample;
use Alfa\Sample\Domain\Model\SampleId;

class SamplePostApplicationService
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
     * @param \Alfa\Sample\Application\SamplePostCommand $command command
     * @return \Alfa\Sample\Application\SamplePostResult
     */
    public function handle(SamplePostCommand $command): SamplePostResult
    {
        $sampleId = SampleId::newId();

        $sample = new Sample(
            $sampleId,
            $command->title,
            $command->content
        );

        $this->transaction->transactional(function () use ($sample) {
            $result = $this->sampleRepository->create($sample);
            if (!$result) {
                throw new TransactionException("[{$sample->getSampleId()}] samples 登録できませんでした。");
            }

            return true;
        });

        return new SamplePostResult(
            $sampleId->asString()
        );
    }
}
