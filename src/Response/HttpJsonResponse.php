<?php
declare(strict_types=1);

namespace Bjyyb\Core\Response;

use Bjyyb\Core\Base\BaseResponse;
use Bjyyb\Core\Constants\GlobalErrorCode;
use Bjyyb\Core\Constants\GlobalStatusCode;
use Bjyyb\Core\Constants\GlobalSuccessCode;
use Psr\Container\ContainerInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

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

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->response = $container->get(ResponseInterface::class);
    }

    /**
     * 输出成功请求
     * @param mixed $data
     * @param int|null $code
     * @param string|null $message
     * @return PsrResponseInterface
     * Author: nf
     * Time: 2020/10/27 16:15
     */
    public function success($data = [], ?int $code = null, ?string $message = null)
    {
        return $this->response->withStatus(GlobalStatusCode::SUCCESS)->json([
            'code' => $code ?? GlobalSuccessCode::SUCCESS,
            'message' => $message ?? GlobalSuccessCode::getMessage(GlobalSuccessCode::SUCCESS),
            'data' => $data,
        ]);
    }

    /**
     * 输出失败请求
     * @param $data
     * @param int|null $code
     * @param string|null $message
     * @return PsrResponseInterface
     * Author: nf
     * Time: 2020/10/27 16:15
     */
    public function fail($data = [], ?int $code = null, ?string $message = null)
    {
        return $this->response->withStatus(GlobalStatusCode::SERVER_ERROR)->json([
            'code' => $code ?? GlobalErrorCode::FAIL,
            'message' => $message ?? GlobalErrorCode::getMessage(GlobalErrorCode::FAIL),
            'data' => $data,
        ]);
    }

    /**
     * 服务名称
     * @return string
     * Author: nf
     * Time: 2020/10/27 15:42
     */
    protected function getServerName(): string
    {
        return 'http';
    }

}