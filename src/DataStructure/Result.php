<?php
declare(strict_types=1);

namespace Bjyyb\Core\DataStructure;

use Bjyyb\Core\Constants\ErrorCode;

/**
 * Note: 包装返回数据体
 * Author: nf
 * Time: 2020/10/29 10:26
 */
class Result
{
    /**
     * 错误码
     * @var int $code
     */
    protected $code;
    /**
     * 提示信息
     * @var string $message
     */
    protected $message;
    /**
     * 返回数据
     * @var mixed $data
     */
    protected $data;

    public function __construct($data, int $code, string $message)
    {
        $this->data = $data;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * 成功结构体
     * @param $data
     * @return Result
     * Author: nf
     * Time: 2020/10/29 10:34
     */
    public static function success($data): Result
    {
        return new self($data, ErrorCode::NORMAL, ErrorCode::getMessage(ErrorCode::NORMAL));
    }

    /**
     * 失败结构体
     * @param int $code
     * @param string $message
     * @return Result
     * Author: nf
     * Time: 2020/10/29 10:35
     */
    public static function fail(int $code, string $message): Result
    {
        return new self([], $code, $message);
    }

    /**
     * 转换数组
     * @return array
     * Author: nf
     * Time: 2020/10/29 10:36
     */
    public function toArray()
    {
        return ['code' => $this->code, 'message' => $this->message, 'data' => $this->data];
    }

}