<?php
declare(strict_types=1);

namespace Bjyyb\Core\Exception;

use Throwable;

/**
 * Note: 通用异常类
 * Author: nf
 * Time: 2020/10/26 15:18
 */
class BaseException extends \RuntimeException
{
    /**
     * 异常标题
     * @var string $title
     */
    protected $title = '业务异常';

    /**
     * @param int $code 错误码
     * @param string $message 自定义错误信息
     * @param Throwable|null $previous
     */
    public function __construct(int $code, string $message, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}