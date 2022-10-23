<?php
declare(strict_types=1);

namespace App\Controller\Api\Sample;

use Alfa\Sample\Application\SampleGetApplicationService;
use Alfa\Sample\Application\SampleGetCommand;
use Alfa\Sample\Infrastructure\Cakephp\SampleRepository;
use App\Controller\AppController;
use Cake\Core\Configure;

class SampleGetController extends AppController
{
    /**
     * @param string $sampleId sampleId
     * @return void
     */
    public function handle(string $sampleId): void
    {
        $sampleRepository = new SampleRepository();
        $applicationService = new SampleGetApplicationService(
            $sampleRepository
        );

        /** @var \Alfa\Sample\Application\SampleGetApplicationService $applicationService */
        $applicationService = Configure::read('Mock.SampleGetApplicationService', $applicationService);

        $command = new SampleGetCommand(
            $sampleId
        );

        $result = $applicationService->handle($command);

        $this->set('data', [
            'sample_id' => $result->sampleId,
            'title' => $result->title,
            'content' => $result->content,
        ]);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
