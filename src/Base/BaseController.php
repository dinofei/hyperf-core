<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;

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

}