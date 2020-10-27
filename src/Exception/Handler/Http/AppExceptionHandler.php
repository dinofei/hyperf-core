<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\Http;

use Bjyyb\Core\Util\LogUtil;
use Bjyyb\Core\Constants\GlobalErrorCode;
use Bjyyb\Core\Constants\GlobalStatusCode;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Exception\HttpException;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Note: 全局异常接管类 作为发生意外错误时 异常托管， 避免重要信息向外泄露
 * Author: nf
 * Time: 2020/10/26 16:59
 */
class AppExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        if ($throwable instanceof HttpException) {
            $statusCode = $throwable->getStatusCode();
        } else {
            $statusCode = GlobalStatusCode::SERVER_ERROR;
        }

        /** 当前为开发环境时 直接将错误信息返给客户端 */
        $message = extract_exception_message($throwable);
        /** 当前为线上环境时 直接将错误信息输出到日志中 并给前端输出友好提示 */
        if (env('APP_ENV', 'dev') !== 'dev') {
            LogUtil::get('http', 'core-default')->error($message);
            $message = GlobalErrorCode::getMessage(GlobalErrorCode::SERVER_ERROR);

        }

        $body = [
            'code' => $throwable->getCode(),
            'message' => $message
        ];

        return $response
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus($statusCode)
            ->withBody(new SwooleStream(json_encode($body, JSON_UNESCAPED_UNICODE)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
