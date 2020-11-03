<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\JsonRpc;

use Bjyyb\Core\Util\LogUtil;
use Hyperf\Contract\ConfigInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
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
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $packerClass = $config->get('protocols.jsonrpc.packer');
        $serverConfig = [];
        foreach ($config->get('server.servers') as $item) {
            if ($item['name'] === 'jsonrpc') {
                $serverConfig = $item;
                break;
            }
        }
        $packer = make($packerClass, $serverConfig);
        /** 把rpc请求ID加入data中 方便链路追踪 */
        $contents = $packer->unpack($response->getBody()->getContents());
        $contents['error']['data']['request_id'] = $contents['id'];
        /** 将异常转化为错误信息 */
        $message = extract_exception_message($throwable);
        /** 将错误信息输出到日志中 方便以后分析 */
        LogUtil::get('jsonrpc', 'core-default')->error($contents['id'] . ' ' . $message);

        return $response->withBody(new SwooleStream($packer->pack($contents)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
