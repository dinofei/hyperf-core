<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\JsonRpc;

use Bjyyb\Core\Exception\BaseException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Note: 业务逻辑异常，不需要记录日志，直接将错误信息返给客户端
 * Author: nf
 * Time: 2020/10/26 16:59
 */
class BaseExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BaseException;
    }
}
