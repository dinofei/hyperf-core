<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\Http;

use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\Constants\StatusCode;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Note: 中间件验证异常接管类
 * Author: nf
 * Time: 2020/10/26 16:59
 */
class ValidationExceptionHandler extends \Hyperf\Validation\ValidationExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $this->stopPropagation();
        /** 参数验证失败时，不需要记录日志，只要把错误信息返回客户端即可 */
        $statusCode = StatusCode::PARAM_ERROR;
        $code = ErrorCode::PARAM_VALIDATE_ERROR;
        $message = $throwable->validator->errors()->first();
        $data = [];
        return $response->withStatus($statusCode)->withBody(new SwooleStream(Json::encode(compact('code', 'message', 'data'))));
    }
}
