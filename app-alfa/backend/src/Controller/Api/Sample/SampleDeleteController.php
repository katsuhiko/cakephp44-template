<?php
declare(strict_types=1);

namespace App\Controller\Api\Sample;

use Alfa\Common\Infrastructure\Cakephp\Transaction;
use Alfa\Sample\Application\SampleDeleteApplicationService;
use Alfa\Sample\Application\SampleDeleteCommand;
use Alfa\Sample\Infrastructure\Cakephp\SampleRepository;
use App\Controller\AppController;
use Cake\Core\Configure;

class SampleDeleteController extends AppController
{
    /**
     * @param string $sampleId sampleId
     * @return void
     */
    public function handle(string $sampleId): void
    {
        $transaction = new Transaction();
        $sampleRepository = new SampleRepository();
        $applicationService = new SampleDeleteApplicationService(
            $transaction,
            $sampleRepository
        );

        /** @var \Alfa\Sample\Application\SampleDeleteApplicationService $applicationService */
        $applicationService = Configure::read('Mock.SampleDeleteApplicationService', $applicationService);

        $command = new SampleDeleteCommand(
            $sampleId
        );

        $result = $applicationService->handle($command);

        $this->set('data', []);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
