<?php
declare(strict_types=1);

namespace Bjyyb\Core\Constants;


use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * Note: 全局异成功状态码枚举类
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
class GlobalSuccessCode extends AbstractConstants
{
    /**
     * @Message("请求成功")
     */
    const SUCCESS = -1;
    /**
     * @Message("新增成功")
     */
    const INSERT_SUCCESS = 9000;
    /**
     * @Message("更新成功")
     */
    const UPDATE_SUCCESS = 9001;
    /**
     * @Message("读取单条记录成功")
     */
    const GET_SUCCESS = 9002;
    /**
     * @Message("读取列表成功")
     */
    const LIST_SUCCESS = 9003;
}