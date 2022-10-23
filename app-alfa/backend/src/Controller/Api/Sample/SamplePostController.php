<?php
declare(strict_types=1);

namespace App\Controller\Api\Sample;

use Alfa\Common\Infrastructure\Cakephp\Transaction;
use Alfa\Sample\Application\SamplePostApplicationService;
use Alfa\Sample\Application\SamplePostCommand;
use Alfa\Sample\Infrastructure\Cakephp\SampleRepository;
use App\Controller\AppController;
use App\Form\Api\Sample\SampleForm;
use Cake\Core\Configure;

class SamplePostController extends AppController
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $transaction = new Transaction();
        $sampleRepository = new SampleRepository();
        $applicationService = new SamplePostApplicationService(
            $transaction,
            $sampleRepository
        );

        /** @var \Alfa\Sample\Application\SamplePostApplicationService $applicationService */
        $applicationService = Configure::read('Mock.SamplePostApplicationService', $applicationService);

        /** @var array<mixed> $data */
        $data = $this->request->getData();
        $form = new SampleForm();
        $isValid = $form->validate($data);
        if (!$isValid) {
            $this->responseValidationError($form->getErrors());

            return;
        }

        $command = new SamplePostCommand(
            strval($data['title']),
            strval($data['content']),
        );

        $result = $applicationService->handle($command);

        $this->set('data', [
            'sample_id' => $result->sampleId,
        ]);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
