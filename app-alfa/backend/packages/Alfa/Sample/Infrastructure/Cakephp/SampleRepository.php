<?php
declare(strict_types=1);

namespace Alfa\Sample\Infrastructure\Cakephp;

use Cake\ORM\Locator\LocatorAwareTrait;
use Alfa\Sample\Domain\Model\ISampleRepository;
use Alfa\Sample\Domain\Model\Sample;
use Alfa\Sample\Domain\Model\SampleId;

final class SampleRepository implements ISampleRepository
{
    use LocatorAwareTrait;

    /**
     * @inheritDoc
     */
    public function create(Sample $sample): bool
    {
        $samplesTable = $this->getTableLocator()->get('Samples');

        /** @var \App\Model\Entity\Sample $entity */
        $entity = $samplesTable->newEmptyEntity();
        $entity->id = $sample->getSampleId()->asString();

        $entity->title = $sample->getTitle();
        $entity->content = $sample->getContent();

        $result = $samplesTable->save($entity, ['atomic' => false, 'checkExisting' => false]);
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function update(Sample $sample): bool
    {
        $samplesTable = $this->getTableLocator()->get('Samples');

        /** @var \App\Model\Entity\Sample $entity */
        $entity = $samplesTable->get($sample->getSampleId()->asString());

        $entity->title = $sample->getTitle();
        $entity->content = $sample->getContent();

        $result = $samplesTable->save($entity, ['atomic' => false, 'checkExisting' => false]);
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function remove(SampleId $sampleId): bool
    {
        $samplesTable = $this->getTableLocator()->get('Samples');

        /** @var ?\App\Model\Entity\Sample $entity */
        $entity = $samplesTable->find()->where(['id' => $sampleId->asString()])->first();
        if (is_null($entity)) {
            return true;
        }

        $result = $samplesTable->delete($entity, ['atomic' => false]);
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function findById(SampleId $sampleId): ?Sample
    {
        $samplesTable = $this->getTableLocator()->get('Samples');

        /** @var ?\App\Model\Entity\Sample $entity */
        $entity = $samplesTable->find()->where(['id' => $sampleId->asString()])->first();
        if (is_null($entity)) {
            return null;
        }

        return new Sample(
            new SampleId($entity->id),
            $entity->title,
            $entity->content
        );
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        $samplesTable = $this->getTableLocator()->get('Samples');

        /** @var \App\Model\Entity\Sample[] $entities */
        $entities = $samplesTable->find()->all()->toList();

        /** @var \Alfa\Sample\Domain\Model\Sample[] $result */
        $result = [];
        foreach ($entities as $entity) {
            $result[] = new Sample(
                new SampleId($entity->id),
                $entity->title,
                $entity->content
            );
        }

        return $result;
    }
}
