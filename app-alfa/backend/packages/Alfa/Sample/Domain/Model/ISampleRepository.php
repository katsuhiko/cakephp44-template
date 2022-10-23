<?php
declare(strict_types=1);

namespace Alfa\Sample\Domain\Model;

interface ISampleRepository
{
    /**
     * @param \Alfa\Sample\Domain\Model\Sample $sample sample
     * @return bool
     */
    public function save(Sample $sample): bool;

    /**
     * @param \Alfa\Sample\Domain\Model\SampleId $sampleId sampleId
     * @return bool
     */
    public function remove(SampleId $sampleId): bool;

    /**
     * @param \Alfa\Sample\Domain\Model\SampleId $sampleId sampleId
     * @return \Alfa\Sample\Domain\Model\Sample
     */
    public function findById(SampleId $sampleId): ?Sample;

    /**
     * @return \Alfa\Sample\Domain\Model\Sample[]
     */
    public function findAll(): array;
}
