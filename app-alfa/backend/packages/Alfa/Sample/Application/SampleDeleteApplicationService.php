<?php
declare(strict_types=1);

namespace Alfa\Sample\Application;

use Alfa\Common\Application\ITransaction;
use Alfa\Common\Domain\Model\TransactionException;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\SampleId;

class SampleDeleteApplicationService
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
     * @param \Alfa\Sample\Application\SampleDeleteCommand $command command
     * @return \Alfa\Sample\Application\SampleDeleteResult
     */
    public function handle(SampleDeleteCommand $command): SampleDeleteResult
    {
        $sampleId = new SampleId($command->sampleId);

        $this->transaction->transactional(function () use ($sampleId) {
            $result = $this->sampleRepository->remove($sampleId);
            if (!$result) {
                throw new TransactionException("[{$sampleId}] samples 削除できませんでした。");
            }

            return true;
        });

        return new SampleDeleteResult();
    }
}
