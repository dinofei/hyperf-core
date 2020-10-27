<?php
declare(strict_types=1);

namespace Bjyyb\Core\Constants;


use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * Note: 全局异请求状态码枚举类
 * Author: nf
 * Time: 2020/10/26 15:23
 *
 * @Constants()
 */
class GlobalStatusCode extends AbstractConstants
{
    /**
     * @Message("服务器内部错误")
     */
    const SERVER_ERROR = 500;
    /**
     * @Message("请求成功")
     */
    const SUCCESS = 200;
    /**
     * @Message("参数验证失败")
     */
    const VALIDATION_FAIL = 400;
    /**
     * @Message("资源不存在")
     */
    const NOT_FOUND = 404;
}