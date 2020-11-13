<?php
/**
 * 通用操作函数库
 */

use Bjyyb\Core\Constants\DbErrorCode;
use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\Exception\BaseException;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\PaginatorInterface;
use Hyperf\Utils\ApplicationContext;

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

if (!function_exists('abort_common_error')) {
    /**
     * 抛出异常
     * @param int $code
     * Author: nf
     * Time: 2020/11/13 9:40
     */
    function abort_common_error(int $code) {
        abort_error($code, ErrorCode::getMessage($code));
    }
}

if (!function_exists('abort_db_error')) {
    /**
     * 抛出异常
     * @param int $code
     * Author: nf
     * Time: 2020/10/29 12:59
     */
    function abort_db_error(int $code) {
        abort_error($code, DbErrorCode::getMessage($code));
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

if (!function_exists('get_jsonrpc_packer')) {
    /**
     * 获取rpc服务的打包协议
     * @param string $name 服务名称
     *
     * Author: nf
     * Time: 2020/11/6 13:53
     */
    function get_jsonrpc_packer(string $name) {
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $packerClass = $config->get('protocols.jsonrpc.packer');
        $serverConfig = [];
        foreach ($config->get('server.servers') as $item) {
            if ($item['name'] === $name) {
                $serverConfig = $item;
                break;
            }
        }
        return make($packerClass, $serverConfig);
    }
}

if (!function_exists('format_paginator')) {
    /**
     * 格式化分页器 返回数组
     * @param PaginatorInterface $paginator
     * @return array
     * Author: nf
     * Time: 2020/11/5 16:20
     */
    function format_paginator(PaginatorInterface $paginator): array {
        return [
            'data' => $paginator->items(),
            'last_page' => $paginator->lastPage(),
            'list_rows' => $paginator->perPage(),
            'current' => $paginator->currentPage(),
            'total' => $paginator->total(),
        ];
    }
}

