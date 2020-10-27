<?php
/**
 * 通用操作函数库
 */

use Bjyyb\Core\Constants\GlobalErrorCode;
use Bjyyb\Core\Base\BaseException;
use Bjyyb\Core\Exception\RepositoryException;
use Bjyyb\Core\Exception\ServiceException;

if (!function_exists('abort_error')) {
    /**
     * 抛出自定义异常
     * @param int $code 错误码 - 枚举类
     * @param string|null $message 自定义信息
     *
     * Author: nf
     * Time: 2020/10/26 20:50
     */
    function abort_error(int $code, ?string $message = null) {
        throw new BaseException($code, $message ?? GlobalErrorCode::getMessage($code));
    }
}

if (!function_exists('abort_service_error')) {
    /**
     * 抛出业务层异常
     * @param int $code 错误码 - 枚举类
     * @param string|null $message 自定义信息
     *
     * Author: nf
     * Time: 2020/10/26 20:50
     */
    function abort_service_error(int $code, ?string $message = null) {
        throw new ServiceException($code, $message ?? GlobalErrorCode::getMessage($code));
    }
}

if (!function_exists('abort_repository_error')) {
    /**
     * 抛出数据层异常
     * @param int $code 错误码 - 枚举类
     * @param string|null $message 自定义信息
     *
     * Author: nf
     * Time: 2020/10/26 20:50
     */
    function abort_repository_error(int $code, ?string $message = null) {
        throw new RepositoryException($code, $message ?? GlobalErrorCode::getMessage($code));
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