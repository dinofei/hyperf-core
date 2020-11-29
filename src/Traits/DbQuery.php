<?php

declare(strict_types=1);

namespace Bjyyb\Core\Traits;

use Hyperf\Database\Model\Model;
use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\Constants\DbErrorCode;
use Hyperf\Database\Model\Collection;
use Hyperf\Contract\PaginatorInterface;

/**
 * 封装仓库通用查询方式
 *
 * Author nf
 * Time 2020-11-29
 */
trait DbQuery
{
    /**
     * 模型存储器
     * @var array
     */
    protected $modelStorage = [];

    /**
     * 获取模型实例
     *
     * @return Model
     * Author nf
     * Time 2020-11-29
     */
    protected function getModelInstance(): Model
    {
        if (!isset($this->modelStorage[static::class])) {
            if (false !== ($name = substr(static::class, 0, -10))) {
                $modelName = sprintf('%sModel', str_replace('Repository', 'Model', $name));
                if (!class_exists($modelName)) {
                    abort_common_error(ErrorCode::MODEL_NOT_FOUND);
                }
                $this->modelStorage[static::class] = $modelName;
            } else {
                abort_common_error(ErrorCode::REPOSITORY_NOT_FOUND, static::class);
            }
        }
        return new $this->modelStorage[static::class]();
    }

    /**
     * 新增单条记录
     * @param array $data
     * @return Model
     * Author: nf
     * Time: 2020/11/19 13:20
     */
    public function insertOne(array $data): Model
    {
        $model = $this->getModelInstance();
        if (!$model->setRawAttributes($data)->save()) {
            abort_db_error(DbErrorCode::INSERT_FAIL);
        }
        return $model;
    }

    /**
     * 更新记录
     * @param array $data
     * @param array $where
     * @return int
     * Author: nf
     * Time: 2020/11/19 14:27
     */
    public function updateByCondition(array $data, array $where): int
    {
        return ($this->getModelInstance())->newQuery()->where($where)->update($data);
    }

    /**
     * 获取单条记录 不存在抛出异常
     * @param array $where
     * @param array|string[] $select
     * @return Model
     * Author: nf
     * Time: 2020/11/19 14:16
     */
    public function getOrFailByCondition(array $where, array $select = ['*']): Model
    {
        $info = $this->getModelInstance()->newQuery()->where($where)->select($select)->first();
        if (is_null($info)) {
            abort_db_error(DbErrorCode::GET_FAIL);
        }
        return $info;
    }

    /**
     * 读取单条记录
     * @param array $where
     * @param array|string[] $select
     * @return Model|null
     * Author: nf
     * Time: 2020/11/19 15:46
     */
    public function getByCondition(array $where, array $select = ['*'])
    {
        return $this->getModelInstance()->newQuery()->where($where)->select($select)->first();
    }

    /**
     * 读取单条记录并加锁
     * @param array $where
     * @param array|string[] $select
     * @return Model|null
     * Author: nf
     * Time: 2020/11/19 15:45
     */
    public function getByConditionAndLock(array $where, array $select = ['*'])
    {
        return $this->getModelInstance()->newQuery()->where($where)->select($select)->lockForUpdate()->first();
    }

    /**
     * 获取单个字段
     * @param string $field
     * @param array $where
     * @return \Hyperf\Utils\HigherOrderTapProxy|mixed|void
     * Author: nf
     * Time: 2020/11/25 10:06
     */
    public function getFieldByCondition(string $field, array $where)
    {
        return $this->getModelInstance()->newQuery()->where($where)->value($field);
    }

    /**
     * 读取列表
     * @param array $where
     * @param string $order
     * @param array $select
     * @return Collection
     * Author: nf
     * Time: 2020/10/29 22:51
     */
    public function listByCondition(array $where, string $order, array $select = ['*']): Collection
    {
        return $this->getModelInstance()->newQuery()->where($where)->select($select)->orderByRaw($order)->get();
    }

    /**
     * 查询分页
     * @param array $where
     * @param string $order
     * @param array|string[] $select
     * @param int $perPage
     * @return PaginatorInterface
     * Author: nf
     * Time: 2020/11/20 15:54
     */
    public function listWithPageByCondition(array $where, string $order, array $select = ['*'], int $perPage = 20): PaginatorInterface
    {
        return $this->getModelInstance()->newQuery()->where($where)->orderByRaw($order)->paginate($perPage, $select);
    }

    /**
     * 根据条件删除
     * @param array $where
     * @return int|mixed
     * Author: nf
     * Time: 2020/11/17 18:12
     */
    public function removeByCondition(array $where)
    {
        return $this->getModelInstance()->newQuery()->where($where)->delete();
    }

    /**
     * 统计数量
     * @param array $where
     * @return int
     * Author: nf
     * Time: 2020/11/18 13:01
     */
    public function countByCondition(array $where): int
    {
        return $this->getModelInstance()->newQuery()->where($where)->count();
    }
}
