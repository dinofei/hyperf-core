<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\JsonRpc;

use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Note: 验证异常接管类 只需要抛出验证异常即可 不需要记录日志
 * Author: nf
 * Time: 2020/10/26 16:59
 */
class ValidationExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}
