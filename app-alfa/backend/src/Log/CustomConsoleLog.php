<?php
declare(strict_types=1);

namespace App\Log;

use Cake\Core\Configure;
use Cake\Log\Engine\ConsoleLog;

class CustomConsoleLog extends ConsoleLog
{
    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = [])
    {
        $message = $this->_format($message, $context);

        $accoutId = strval(Configure::read('Account.id'));
        $sessionId = session_id();
        $message = "[{$accoutId}][$sessionId] {$message}";

        parent::log($level, $message, $context);
    }
}
