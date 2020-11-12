<?php
declare(strict_types=1);

namespace Bjyyb\Core\Constants;


use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * Note: 数据库错误码枚举
 *
 * @Constants()
 *
 * @method static string getMessage(int $code)
 *
 * Author: nf
 * Time: 2020/10/29 11:30
 */
class DbErrorCode extends AbstractConstants
{
    /**
     * @Message("插入失败")
     */
    const INSERT_FAIL = 3100;
    /**
     * @Message("更新失败")
     */
    const UPDATE_FAIL = 3101;
    /**
     * @Message("读取数据失败")
     */
    const GET_FAIL = 3102;
    /**
     * @Message("查询参数错误")
     */
    const SELECT_PARAM_ERROR = 3103;
    /**
     * @Message("分页查询页码错误")
     */
    const PAGE_ERROR = 3104;
    /**
     * @Message("删除失败")
     */
    const DELETE_FAIL = 3101;

}