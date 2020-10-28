<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;

use Bjyyb\Core\Response\HttpJsonResponse;
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
     * @var HttpJsonResponse
     */
    protected $response;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->response = $container->get(HttpJsonResponse::class);
    }

}