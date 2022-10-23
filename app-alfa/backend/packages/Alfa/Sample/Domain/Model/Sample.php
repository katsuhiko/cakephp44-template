<?php
declare(strict_types=1);

namespace Alfa\Sample\Domain\Model;

final class Sample
{
    /**
     * @param \Alfa\Sample\Domain\Model\SampleId $sampleId sampleId
     * @param string $title title
     * @param string $content content
     */
    public function __construct(
        private SampleId $sampleId,
        private string $title,
        private string $content
    ) {
    }

    /**
     * @return \Alfa\Sample\Domain\Model\SampleId
     */
    public function getSampleId(): SampleId
    {
        return $this->sampleId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
