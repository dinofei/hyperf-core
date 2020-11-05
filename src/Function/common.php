<?php
/**
 * 通用操作函数库
 */

use Bjyyb\Core\Exception\BaseException;
use Hyperf\Contract\LengthAwarePaginatorInterface;

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
        return sprintf("标题：%s --- 文件：%s --- 行数：%s信息：%s --- 追溯：%s",
            $prefix,
            $e->getFile(),
            $e->getLine(),
            $e->getMessage(),
            str_replace(["\r\n", "\n"], '', $e->getTraceAsString())
        );
    }
}

if (!function_exists('format_paginator')) {
    /**
     * 格式化分页器 返回数组
     * @param LengthAwarePaginatorInterface $paginator
     * @return array
     * Author: nf
     * Time: 2020/11/5 16:20
     */
    function format_paginator(LengthAwarePaginatorInterface $paginator): array {
        return [
            'data' => $paginator->items(),
            'list_page' => $paginator->lastPage(),
            'list_rows' => $paginator->perPage(),
            'current' => $paginator->currentPage(),
        ];
    }
}