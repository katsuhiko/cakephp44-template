<?php
declare(strict_types=1);

namespace Alfa\Common\Domain\Model;

class TransactionException extends DomainException
{
    protected $errorCode = 102;
    protected $errorTitle = 'トランザクション処理に失敗しました。';
}
