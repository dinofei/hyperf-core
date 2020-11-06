<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\Http;

use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\DataStructure\Result;
use Bjyyb\Core\Util\LogUtil;
use Bjyyb\Core\Constants\StatusCode;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Codec\Json;
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
        $this->stopPropagation();
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        $statusCode = StatusCode::SERVER_ERROR;
        $code = ErrorCode::SERVER_ERROR;
        /** 当前为开发环境时 直接将错误信息返给客户端 */
        $message = extract_exception_message($throwable);
        /** 当前为线上环境时 给前端输出友好提示 */
        if (env('APP_ENV', 'dev') !== 'dev') {
            $message = ErrorCode::getMessage($code);
        }
        /** 将错误信息输出到日志中  方便以后分析 */
        $context = [
            'url' => $request->fullUrl(),
            'method' => $request->getMethod(),
            'params' => $request->all(),
        ];
        LogUtil::get(env('APP_NAME') . ':http', 'core-default')->error($message, $context);

        $result = Result::fail($code, $message);
        return $response
            ->withHeader('Content-type', 'application/json;charset=utf-8')
            ->withStatus($statusCode)
            ->withBody(new SwooleStream(Json::encode($result->toArray())));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
