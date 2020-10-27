<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;

use Bjyyb\Core\Constants\GlobalErrorCode;
use Throwable;

/**
 * Note: 自定义异常基类
 * Author: nf
 * Time: 2020/10/26 15:18
 */
class BaseException extends \RuntimeException
{
    /**
     * 异常标题
     * @var string $title
     */
    protected $title = 'Bjyyb\Core\Exception\BaseException';

    /**
     * @param int $code 错误码
     * @param null $message 自定义错误信息 留空使用错误码对应信息
     * @param Throwable|null $previous
     */
    public function __construct(int $code, $message = null, Throwable $previous = null)
    {
        parent::__construct($message ?? GlobalErrorCode::getMessage($code), $code, $previous);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}