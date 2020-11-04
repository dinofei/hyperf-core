<?php
declare(strict_types=1);

namespace Bjyyb\Core\Factory;

use Bjyyb\Core\Util\LogUtil;

/**
 * Note: 默认日志工厂类替换
 * Author: nf
 * Time: 2020/11/4 10:32
 */
class StdoutLoggerFactory
{

    public function __invoke()
    {
        return LogUtil::get('app', 'core-default');
    }

}