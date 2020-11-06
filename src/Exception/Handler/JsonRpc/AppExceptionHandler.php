<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\JsonRpc;

use Bjyyb\Core\Util\LogUtil;
use Hyperf\Contract\ConfigInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\ApplicationContext;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * Note: 全局异常接管类 作为发生意外错误时异常托管， 只需要记录日志信息即可
 * Author: nf
 * Time: 2020/10/26 16:59
 */
class AppExceptionHandler extends ExceptionHandler
{
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /** 获取当前jsconrpc服务的数据打包协议$packer */
        $packer = get_jsonrpc_packer('jsonrpc');
        /** 把rpc请求ID加入data中 方便链路追踪 */
        $contents = $packer->unpack($response->getBody()->getContents());
        $contents['error']['data']['response_id'] = $contents['id'];
        /** 将异常转化为错误信息 */
        $message = extract_exception_message($throwable);
        /** 将错误信息输出到日志中 方便以后分析 */
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        /** 服务端异常 只需要返回response_id就可以了 因为链路在这里就停止了 */
        $context = ['data' => $request->getAttribute('data'), 'response_id' => $contents['id']];
        LogUtil::get(env('APP_NAME') . ':jsonrpc-server', 'core-default')->error($message, $context);

        return $response->withBody(new SwooleStream($packer->pack($contents)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }



}
