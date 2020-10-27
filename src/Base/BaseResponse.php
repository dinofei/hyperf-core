<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;

/**
 * Note: 响应输出抽象基类
 * Author: nf
 * Time: 2020/10/26 16:06
 */
abstract class BaseResponse
{
    /**
     * 获取服务名称
     * @return string
     * Author: nf
     * Time: 2020/10/27 15:47
     */
    abstract protected function getServerName();
}