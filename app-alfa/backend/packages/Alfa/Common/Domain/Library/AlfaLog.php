<?php
declare(strict_types=1);

namespace Alfa\Common\Domain\Library;

use Cake\Error\Debugger;
use Cake\Log\Log;
use Psr\Log\LogLevel;
use Throwable;

final class AlfaLog
{
    /**
     * https://book.cakephp.org/4/ja/core-libraries/logging.html#writing-to-logs
     *
     * LogTrait を使ったときと同じ I/F でログを出力できます。
     *
     * Convenience method to write a message to Log. See Log::write()
     * for more information on writing to logs.
     *
     * @param string $message Log message.
     * @param int|string $level Error level.
     * @param string|array $context Additional log data relevant to this message.
     * @return bool Success of log write.
     */
    public static function log(string $message, $level = LogLevel::ERROR, $context = []): bool
    {
        return Log::write($level, $message, $context);
    }

    /**
     * Cake\Error\ErrorLogger#getMessage() を簡易的に移植しました。
     * 例外内容をログへ出力します。
     *
     * @param \Throwable $exception exception
     * @return bool
     */
    public static function logException(Throwable $exception): bool
    {
        $message = sprintf(
            '%s[%s] %s in %s on line %s',
            get_class($exception),
            '',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );

        /** @var array $trace */
        $trace = Debugger::formatTrace($exception, ['format' => 'points']);
        $message .= "\nStack Trace:\n";
        foreach ($trace as $line) {
            if (is_string($line)) {
                $message .= '- ' . $line;
            } else {
                $message .= "- {$line['file']}:{$line['line']}\n";
            }
        }

        return Log::write(LogLevel::ERROR, $message, []);
    }
}
