<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\Http;

use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\Constants\StatusCode;
use Bjyyb\Core\DataStructure\Result;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Note: 验证异常接管类 只需要抛出验证异常即可 不需要记录日志
 * Author: nf
 * Time: 2020/10/26 16:59
 */
class ValidationExceptionHandler extends \Hyperf\Validation\ValidationExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $this->stopPropagation();
        $statusCode = StatusCode::PARAM_ERROR;
        $code = ErrorCode::PARAM_VALIDATE_ERROR;
        $message = $throwable->validator->errors()->first();
        $result = Result::fail($code, $message);
        return $response
            ->withHeader('Content-type', 'application/json;charset=utf-8')
            ->withStatus($statusCode)
            ->withBody(new SwooleStream(Json::encode($result->toArray())));
    }
}
