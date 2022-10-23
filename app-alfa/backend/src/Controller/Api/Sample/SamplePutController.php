<?php
declare(strict_types=1);

namespace App\Controller\Api\Sample;

use Alfa\Common\Infrastructure\Cakephp\Transaction;
use Alfa\Sample\Application\SamplePutApplicationService;
use Alfa\Sample\Application\SamplePutCommand;
use Alfa\Sample\Infrastructure\Cakephp\SampleRepository;
use App\Controller\AppController;
use App\Form\Api\Sample\SampleForm;
use Cake\Core\Configure;

class SamplePutController extends AppController
{
    /**
     * @param string $sampleId sampleId
     * @return void
     */
    public function handle(string $sampleId): void
    {
        $transaction = new Transaction();
        $sampleRepository = new SampleRepository();
        $applicationService = new SamplePutApplicationService(
            $transaction,
            $sampleRepository
        );

        /** @var \Alfa\Sample\Application\SamplePutApplicationService $applicationService */
        $applicationService = Configure::read('Mock.SamplePutApplicationService', $applicationService);

        /** @var array<mixed> $data */
        $data = $this->request->getData();
        $form = new SampleForm();
        $isValid = $form->validate($data);
        if (!$isValid) {
            $this->responseValidationError($form->getErrors());

            return;
        }

        $command = new SamplePutCommand(
            $sampleId,
            strval($data['title']),
            strval($data['content']),
        );

        $result = $applicationService->handle($command);

        $this->set('data', []);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
