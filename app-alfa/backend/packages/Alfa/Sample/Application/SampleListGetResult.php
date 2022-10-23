<?php
declare(strict_types=1);

namespace Alfa\Sample\Application;

final class SampleListGetResult
{
    /**
     * @param \Alfa\Sample\Application\SampleResult[] $samples samples
     */
    public function __construct(
        public array $samples
    ) {
    }
}
