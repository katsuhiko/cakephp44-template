<?php
declare(strict_types=1);

namespace App\Controller\Api\Sample;

use Alfa\Sample\Application\SampleListGetApplicationService;
use Alfa\Sample\Application\SampleListGetCommand;
use Alfa\Sample\Infrastructure\Cakephp\SampleRepository;
use App\Controller\AppController;
use Cake\Core\Configure;

class SampleListGetController extends AppController
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $sampleRepository = new SampleRepository();
        $applicationService = new SampleListGetApplicationService(
            $sampleRepository
        );

        /** @var \Alfa\Sample\Application\SampleListGetApplicationService $applicationService */
        $applicationService = Configure::read('Mock.SampleListGetApplicationService', $applicationService);

        $command = new SampleListGetCommand();

        $result = $applicationService->handle($command);

        $data = [];
        foreach ($result->samples as $sample) {
            $data[] = [
                'sample_id' => $sample->sampleId,
                'title' => $sample->title,
                'content' => $sample->content,
            ];
        }

        $this->set('data', $data);
        $this->viewBuilder()->setOption('serialize', ['data']);
    }
}
