<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;

use Hyperf\DbConnection\Model\Model;

/**
 * Note: 模型抽象基类
 * Author: nf
 * Time: 2020/10/28 10:52
 */
abstract class BaseModel extends Model
{

    /**
     * 存入时使用int字段代替时间戳字段
     * @param mixed $value
     * @return int|string|null
     */
    public function fromDateTime($value)
    {
        return empty($value) ? 0 : $this->asDateTime($value)->getTimestamp();
    }

    /**
     * 取出时时间戳转换为日期
     * @return string|null
     * Author: nf
     * Time: 2020/10/28 10:53
     */
    public function freshTimestampString(): ?string
    {
        return (string) $this->fromDateTime($this->freshTimestamp());
    }

}
