<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\Http;


use Bjyyb\Core\Constants\GlobalErrorCode;
use Bjyyb\Core\Constants\GlobalStatusCode;
use Bjyyb\Core\Base\BaseException;
use Bjyyb\Core\Util\LogUtil;
use Hyperf\Validation\ValidationExceptionHandler;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Throwable;

/**
 * 通用异常 获取异常错误码和错误信息返回给客户端 不需要记录日志
 */
class BaseExceptionHandler extends ValidationExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();

        $statusCode = GlobalStatusCode::SERVER_ERROR;

        /** @var BaseException $throwable */
        /** 当前为开发环境时 直接将错误信息返给客户端 */
        $message = extract_exception_message($throwable, $throwable->getTitle());
        /** 当前为线上环境时 直接将错误信息输出到日志中 并给前端输出友好提示 */
        if (env('APP_ENV', 'dev') !== 'dev') {
            LogUtil::get('http', 'core-default')->error($message);
            $message = GlobalErrorCode::getMessage($throwable->getCode()) ?? GlobalErrorCode::getMessage(GlobalErrorCode::SERVER_ERROR);
        }

        $body = [
            'code' => $throwable->getCode(),
            'message' => $message,
        ];

        return $response
            ->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus($statusCode)
            ->withBody(new SwooleStream(json_encode($body, JSON_UNESCAPED_UNICODE)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BaseException;
    }
}