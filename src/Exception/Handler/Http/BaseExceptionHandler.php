<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\Http;

use Bjyyb\Core\Constants\StatusCode;
use Bjyyb\Core\DataStructure\Result;
use Bjyyb\Core\Exception\BaseException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
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
        $statusCode = StatusCode::Fail;
        $result = Result::fail($throwable->getCode(), $throwable->getMessage());
        return $response
            ->withHeader('Content-type', 'application/json;charset=utf-8')
            ->withStatus($statusCode)
            ->withBody(new SwooleStream(Json::encode($result->toArray())));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BaseException;
    }
}
