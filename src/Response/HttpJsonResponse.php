<?php
declare(strict_types=1);

namespace Bjyyb\Core\Response;

use Bjyyb\Core\Base\BaseResponse;
use Bjyyb\Core\Constants\GlobalStatusCode;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Note: Http服务输出
 * Author: nf
 * Time: 2020/10/27 15:09
 */
class HttpJsonResponse extends BaseResponse
{
    /**
     * @var ResponseInterface $response
     */
    protected $response;
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    private function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->response = $container->get(ResponseInterface::class);
    }

    /**
     * 输出成功请求
     * @param mixed $data
     * @param int $code
     * @param string $message
     * @return ResponseInterface
     * Author: nf
     * Time: 2020/10/27 16:15
     */
    public function success($data, int $code, string $message)
    {
        return $this->response->withStatus(GlobalStatusCode::SUCCESS)->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * 输出失败请求
     * @param $data
     * @param int $code
     * @param string|null $message
     * @return ResponseInterface
     * Author: nf
     * Time: 2020/10/27 16:15
     */
    public function fail($data, int $code, string $message)
    {
        return $this->response->withStatus(GlobalStatusCode::SERVER_ERROR)->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * 服务名称
     * @return string
     * Author: nf
     * Time: 2020/10/27 15:42
     */
    protected function getServerName()
    {
        return 'http';
    }

}