<?php
declare(strict_types=1);

namespace Bjyyb\Core\Constants;


use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * Note: 全局异常错误码枚举类
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
class GlobalErrorCode extends AbstractConstants
{
    /**
     * @Message("请求失败")
     */
    const FAIL = 9999;
    /**
     * @Message("服务器内部错误")
     */
    const SERVER_ERROR = 10000;
    /**
     * @Message("新增失败")
     */
    const INSERT_FAIL = 10100;
    /**
     * @Message("更新失败")
     */
    const UPDATE_FAIL = 10101;
    /**
     * @Message("读取单条记录失败")
     */
    const GET_FAIL = 10102;
    /**
     * @Message("读取列表失败")
     */
    const LIST_FAIL = 10103;
    /**
     * @Message("状态异常")
     */
    const STATE_EXCEPTION = 10200;
    /**
     * @Message("类不存在异常")
     */
    const CLASS_NOT_FOUND = 20000;
    /**
     * @Message("类方法不存在异常")
     */
    const CLASS_METHOD_NOT_FOUND = 20001;
    /**
     * @Message("dto对象必须继承自 Bjyyb\Core\DTO\BaseDTO")
     */
    const DTO_MUST_EXTENDS_BASEDTO = 20200;
    /**
     * @Message("获取dto对象参数必须先实例化内部验证器")
     */
    const DTO_MUST_INSTANCE_VALIDATOR = 20201;
}