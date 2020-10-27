<?php
declare(strict_types=1);

namespace Bjyyb\Core\Response;

use Bjyyb\Core\Base\BaseResponse;

/**
 * Note: jsonrpc服务输出
 * Author: nf
 * Time: 2020/10/27 15:09
 */
class JsonRpcResponse extends BaseResponse
{

    /**
     * 输出成功请求
     * @param mixed $data
     * @param int $code
     * @param string
     * @return array
     * Author: nf
     * Time: 2020/10/27 16:15
     */
    public function success($data, int $code, string $message)
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * 输出失败请求
     * @param $data
     * @param int $code
     * @param string|null $message
     * @return array
     * Author: nf
     * Time: 2020/10/27 16:15
     */
    public function fail($data, int $code, string $message)
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * 服务名称
     * @return string
     * Author: nf
     * Time: 2020/10/27 15:42
     */
    protected function getServerName()
    {
        return 'jsonrpc';
    }

}