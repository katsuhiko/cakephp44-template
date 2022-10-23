<?php
declare(strict_types=1);

namespace Alfa\Sample\Application;

final class SampleResult
{
    /**
     * @param string $sampleId sampleId
     * @param string $title title
     * @param string $content content
     */
    public function __construct(
        public string $sampleId,
        public string $title,
        public string $content
    ) {
    }
}
