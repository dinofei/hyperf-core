<?php

declare(strict_types=1);

namespace Bjyyb\Core\Base;

use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;

/**
 * Note: 控制器抽象类
 * Author: nf
 * Time: 2020/10/27 19:09
 */
abstract class BaseController
{
    /** 
     * @Inject()
     * @var ContainerInterface $container 
     */
    protected $container;
}
