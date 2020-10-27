<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;

use Bjyyb\Core\Response\HttpJsonResponse;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;

/**
 * Note: 控制器抽象类
 * Author: nf
 * Time: 2020/10/27 19:09
 */
abstract class BaseController
{
    /** @var ContainerInterface $container */
    protected $container;
    /**
     * @Inject()
     * @var HttpJsonResponse
     */
    protected $response;

    /**
     * 输出成功请求
     * @param $data
     * @param int $code
     * @return mixed
     * Author: nf
     * Time: 2020/10/27 19:11
     */
    protected function success($data, int $code)
    {
        return $this->response->success($data, $code);
    }

    /**
     * 输出失败请求
     * @param int $code
     * @param string|null $message
     * @return mixed
     * Author: nf
     * Time: 2020/10/27 19:12
     */
    protected function fail(int $code, ?string $message = null)
    {
        return $this->response->fail($code, $message);
    }
}