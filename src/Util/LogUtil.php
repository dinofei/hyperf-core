<?php
declare(strict_types=1);

namespace Bjyyb\Core\Util;

use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;

/**
 * Note: 日志记录工具
 * Author: nf
 * Time: 2020/10/26 17:17
 */
class LogUtil
{
    /**
     * @param string $name 日志类型 (日志信息的标题)
     * @param string $key 配置的管道 默认输出到控制台
     * @return \Psr\Log\LoggerInterface
     * Author: nf
     * Time: 2020/10/26 17:17
     */
    public static function get(string $name = 'app', string $key = 'core-std')
    {
        return ApplicationContext::getContainer()->get(LoggerFactory::class)->get($name, $key);
    }
}