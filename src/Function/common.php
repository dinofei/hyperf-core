<?php
/**
 * 通用操作函数库
 */

use Bjyyb\Core\Exception\BaseException;

if (!function_exists('abort_error')) {
    /**
     * 抛出自定义异常
     * @param int $code 错误码
     * @param string $message 自定义信息
     *
     * Author: nf
     * Time: 2020/10/26 20:50
     */
    function abort_error(int $code, string $message) {
        throw new BaseException($code, $message);
    }
}

if (!function_exists('extract_exception_message')) {
    /**
     * 提取异常中的错误信息 返回字符串
     * @param Throwable $e
     * @param string $prefix
     * @return string
     * Author: nf
     * Time: 2020/10/26 20:53
     */
    function extract_exception_message(\Throwable $e, string $prefix = '错误记录'): string {
        return <<<ERROR
主题：{$prefix}
文件：{$e->getFile()}
行数：{$e->getLine()}
信息：{$e->getMessage()}
追溯：{$e->getTraceAsString()}
ERROR;
    }
}