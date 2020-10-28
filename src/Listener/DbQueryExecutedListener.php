<?php

declare(strict_types=1);

namespace Bjyyb\Core\Listener;

use Bjyyb\Core\Util\LogUtil;
use Hyperf\Database\Events\QueryExecuted;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Utils\Arr;
use Hyperf\Utils\Str;

/**
 * Note: 监听SQL执行
 *
 * Author: nf
 * Time: 2020/10/28 11:48
 */
class DbQueryExecutedListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            QueryExecuted::class,
        ];
    }

    /**
     * @param QueryExecuted $event
     */
    public function process(object $event)
    {
        if (!env('WRITE_SQL_LOG')) {
            return;
        }
        if ($event instanceof QueryExecuted) {
            $sql = $event->sql;
            if (! Arr::isAssoc($event->bindings)) {
                foreach ($event->bindings as $key => $value) {
                    $sql = Str::replaceFirst('?', "'{$value}'", $sql);
                }
            }

            LogUtil::get('sql', 'core-sql')->info(sprintf('[%s] %s', $event->time, $sql));
        }
    }
}
