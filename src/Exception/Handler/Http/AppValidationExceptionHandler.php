<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\Http;


use Bjyyb\Core\Constants\GlobalStatusCode;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Validation\ValidationExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Note: 参数验证失败时异常接管 ， 不需要记录日志， 只要把错误信息包装返回客户端即可
 * Author: nf
 * Time: 2020/10/26 21:10
 */
class AppValidationExceptionHandler extends ValidationExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $error = $throwable->validator->errors()->first();

        $body = [
            'code' => $throwable->getCode(),
            'message' => $error,
        ];

        return $response
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus(GlobalStatusCode::VALIDATION_FAIL)
            ->withBody(new SwooleStream(json_encode($body, JSON_UNESCAPED_UNICODE)));
    }

}