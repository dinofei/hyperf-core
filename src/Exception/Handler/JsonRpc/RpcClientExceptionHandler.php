<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception\Handler\JsonRpc;

use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\DataStructure\Result;
use Bjyyb\Core\Exception\BaseException;
use Bjyyb\Core\Util\LogUtil;
use Bjyyb\Core\Constants\StatusCode;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\RpcClient\Exception\RequestException;
use Hyperf\Utils\ApplicationContext;
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
        /** 获取当前jsconrpc服务的数据打包协议$packer */
        $packer = get_jsonrpc_packer('jsonrpc');
        /** 把rpc请求ID加入data中 方便链路追踪 */
        $contents = $packer->unpack($response->getBody()->getContents());
        $contents['error']['data']['response_id'] = $contents['id'];

        /** 当为参数验证失败或为业务抛出异常时的场景时不需要处理  */
        if (empty($data) || !in_array($data['class'], [ValidationException::class, BaseException::class])) {
            /** 将错误信息输出到日志中 方便以后分析 */
            $request = ApplicationContext::getContainer()->get(RequestInterface::class);
            /** 由于该服务即作为服务端又做为客户端，作为链路的中间者，需要在日志中分别记录request_id和response_id */
            $context = [
                'data' => $request->getAttribute('data'),
                'response_id' => $contents['id'] ?? 'no_response_id',
                'request_id' => $data['response_id'] ?? 'no_request_id'
            ];
            LogUtil::get(env('APP_NAME') . ':jsonrpc-client', 'core-default')->error($data['message'], $context);
        }

        return $response->withBody(new SwooleStream($packer->pack($contents)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof RequestException;
    }
}
