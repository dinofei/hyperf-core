<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\Http;

use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\DataStructure\Result;
use Bjyyb\Core\Exception\BaseException;
use Bjyyb\Core\Util\LogUtil;
use Bjyyb\Core\Constants\StatusCode;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\RpcClient\Exception\RequestException;
use Hyperf\Utils\Codec\Json;
use Hyperf\Validation\ValidationException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Note: RPC客户端异常接管类
 * Author: nf
 * Time: 2020/10/26 16:59
 */
class RpcClientExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /** @var RequestException $throwable */
        
        $data = $throwable->getThrowable();

        if (!empty($data)) {
            if ($data['class'] === ValidationException::class) {
                /** 当为参数验证失败时的场景时  直接输出错误信息 */
                $statusCode = StatusCode::PARAM_ERROR;
                $code = ErrorCode::PARAM_VALIDATE_ERROR;
                $message = $data['message'];
            } elseif ($data['class'] === BaseException::class) {
                /** 当为业务抛出异常的场景时  直接输出错误信息 */
                $statusCode = StatusCode::Fail;
                $code = $data['code'];
                $message = $data['message'];
            } else {
                /** 预料之外的异常 需要记录错误信息到日志 并且生产环境下避免输出敏感信息 */
                /** 加上rpc请求ID 便于以后查询追踪 */
                $prefix = $data['request_id'] ?? 'no_request_id';
                $statusCode = StatusCode::SERVER_ERROR;
                $code = ErrorCode::SERVER_ERROR;
                $message = $prefix . ' ' . $data['message'];
                if (env('APP_ENV', 'dev') !== 'dev') {
                    LogUtil::get('jsonrpc-client', 'core-default')->error($message);
                    $message = '请求ID：' . $prefix . ' ' . ErrorCode::getMessage($code);
                }
            }
        } else {
            /** 预料之外的异常 需要记录错误信息到日志 并且生产环境下避免输出敏感信息 */
            $prefix = 'no_request_id';
            $statusCode = StatusCode::SERVER_ERROR;
            $code = ErrorCode::SERVER_ERROR;
            $message = $throwable->getMessage();
            if (env('APP_ENV', 'dev') !== 'dev') {
                LogUtil::get('jsonrpc-client', 'core-default')->error($message);
                $message = '请求ID：' . $prefix . ' ' . ErrorCode::getMessage($code);
            }
        }
        $result = Result::fail($code, $message);
        return $response
            ->withStatus($statusCode)
            ->withHeader('Content-type', 'application/json;charset=utf-8')
            ->withBody(new SwooleStream(Json::encode($result->toArray())));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof RequestException;
    }
}
