<?php
declare(strict_types=1);

namespace Bjyyb\Core\Constants;


use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * Note: Http状态码枚举类
 *
 * @method static string getMessage(int $code) 获取提示信息
 *
 * @Constants()
 *
 *
 * Author: nf
 * Time: 2020/10/26 15:23
 *
 *
 */
class StatusCode extends AbstractConstants
{
    /**
     * @Message("请求失败")
     */
    const Fail = 500;
    /**
     * @Message("请求成功")
     */
    const SUCCESS = 200;
    /**
     * @Message("参数异常")
     */
    const PARAM_ERROR = 400;
    /**
     * @Message("身份验证失败")
     */
    const LOGIN_AUTH_ERROR = 401;
    /**
     * @Message("权限验证失败")
     */
    const AUTH_ERROR = 403;
    /**
     * @Message("服务器内部异常")
     */
    const SERVER_ERROR = 503;
}