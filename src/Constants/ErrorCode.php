<?php

declare(strict_types=1);

namespace Bjyyb\Core\Constants;


use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * Note: 错误码枚举类
 *
 * @method static string getMessage(int $code) 获取提示信息
 *
 * @Constants()
 *
 *
 * Author: nf
 * Time: 2020/10/26 15:23
 *
 */
class ErrorCode extends AbstractConstants
{
    /**
     * 0 无错误
     * 1000 ~ 1999 参数错误码 （参数校验失败，格式有误）
     * 2000 ~ 2999 客户端异常 （用户状态异常，权限校验失败。。。）
     * 3000 ~ 3999 业务错误码 （数据获取失败，返回数据异常，数据操作失败，主动捕获的异常状态。。。）
     * 4000 ~ 4999 异常错误码 （系统异常、php错误）
     *
     * note: 1000 ~ 3999 是可以传递给外部接口和客户端的 4000 ~ 错误信息记录到日志，不能传递到外部
     */

    /**
     * @Message("请求成功")
     */
    const NORMAL = 0;

    /**
     * @Message("参数验证失败")
     */
    const PARAM_VALIDATE_ERROR = 1000;

    /**
     * @Message("用户权限验证失败")
     */
    const USER_AUTH_ERROR = 2000;

    /**
     * @Message("获取数据失败")
     */
    const GET_ERROR = 3000;
    /**
     * @Message("获取列表数据失败")
     */
    const LIST_ERROR = 3001;

    /**
     * @Message("服务器内部错误")
     */
    const SERVER_ERROR = 4000;
    /**
     * @Message("未找到相关仓库类")
     */
    const REPOSITORY_NOT_FOUND = 10001;
    /**
     * @Message("未找到相关模型类")
     */
    const MODEL_NOT_FOUND = 10002;
}
