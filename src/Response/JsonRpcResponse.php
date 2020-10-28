<?php
declare(strict_types=1);

namespace Bjyyb\Core\Response;

use Bjyyb\Core\Base\BaseResponse;
use Bjyyb\Core\Constants\GlobalErrorCode;
use Bjyyb\Core\Constants\GlobalSuccessCode;

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
     * @param int|null $code
     * @param string|null $message
     * @return array
     * Author: nf
     * Time: 2020/10/27 16:15
     */
    public function success($data = [], ?int $code = null, ?string $message = null): array
    {
        return [
            'code' => $code ?? GlobalSuccessCode::SUCCESS,
            'message' => $message ?? GlobalSuccessCode::getMessage(GlobalSuccessCode::SUCCESS),
            'data' => $data,
        ];
    }

    /**
     * 输出失败请求
     * @param mixed $data
     * @param int|null $code
     * @param string|null $message
     * @return array
     * Author: nf
     * Time: 2020/10/27 16:15
     */
    public function fail($data = [], ?int $code = null, ?string $message = null): array
    {
        return [
            'code' => $code ?? GlobalErrorCode::FAIL,
            'message' => $message ?? GlobalErrorCode::getMessage(GlobalErrorCode::FAIL),
            'data' => $data,
        ];
    }

    /**
     * 服务名称
     * @return string
     * Author: nf
     * Time: 2020/10/27 15:42
     */
    protected function getServerName(): string
    {
        return 'jsonrpc';
    }

}