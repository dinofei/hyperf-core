<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;

use Bjyyb\Core\Constants\ErrorCode;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Context;

/**
 * Note: 查询条件
 *
 * @method $this setSelect(array $select)
 * @method $this setWhere(array $where = [])
 * @method $this setOrder(string $raw)
 * @method $this setPerPage(int $perPage)
 * @method $this addWhereAttribute(array $where)
 * @method array getWhere()
 * @method int getPerPage()
 * @method array getSelect()
 * @method string getOrder()
 *
 * Author: nf
 * Time: 2020/11/12 15:22
 */
abstract class BaseCondition
{
    /** @var RequestInterface */
    protected $request;
    /** @var string 同步类型 */
    protected $type;
    /** @var array 查询条件 */
    protected $where = [];
    /** @var string[] 查询字段 */
    protected $select = ['*'];
    /** @var string 排序 */
    protected $order = 'id asc';
    /** @var int 分页步长 */
    protected $perPage = 20;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * 获取实例
     * @return BaseCondition
     * Author: nf
     * Time: 2020/11/5 16:42
     */
    public function getInstance()
    {
        $id = get_called_class();
        if (!Context::has($id)) {
            Context::set($id, make(static::class));
        }
        return Context::get($id);
    }

    /**
     * 设置查询条件
     * @param array $data
     * @return $this
     * Author: nf
     * Time: 2020/11/5 17:05
     */
    protected function _setWhere(array $data = [])
    {
        $this->where = $data;
        return $this;
    }

    /**
     * 设置查询字段
     * @param array $select
     * @return $this
     * Author: nf
     * Time: 2020/11/5 17:01
     */
    protected function _setSelect(array $select)
    {
        $this->select = $select;
        return $this;
    }

    /**
     * 设置排序字段
     * @param string $raw
     * @return $this
     * Author: nf
     * Time: 2020/11/5 17:01
     */
    protected function _setOrder(string $raw)
    {
        $this->order = $raw;
        return $this;
    }

    /**
     * 添加where条件
     * @param array $where
     * @return $this
     * Author: nf
     * Time: 2020/11/13 16:10
     */
    protected function _addWhereAttribute(array $where)
    {
        $this->where[] = $where;
        return $this;
    }

    /**
     * 设置查询条目
     * @param int $perPage
     * @return $this
     * Author: nf
     * Time: 2020/11/5 17:01
     */
    protected function _setPerPage(int $perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * 获取查询条件
     * @return array
     * Author: nf
     * Time: 2020/11/5 17:02
     */
    protected function _getWhere()
    {
        return $this->where;
    }

    /**
     * 获取查询条目
     * @return int
     * Author: nf
     * Time: 2020/11/5 17:02
     */
    protected function _getPerPage()
    {
        return $this->perPage;
    }

    /**
     * 获取查询字段
     * @return string[]
     * Author: nf
     * Time: 2020/11/5 17:02
     */
    protected function _getSelect()
    {
        return $this->select;
    }

    /**
     * 获取排序字段
     * @return string
     * Author: nf
     * Time: 2020/11/5 17:02
     */
    protected function _getOrder()
    {
        return $this->order;
    }

    public function __call($name, $arguments)
    {
        $instance = $this->getInstance();
        $method = '_' . $name;
        if (!method_exists($instance, $method)) {
            abort_error(ErrorCode::SERVER_ERROR, $name . '方法在类' . get_called_class() . '中不存在');
        }
        return $instance->{$method}(...$arguments);
    }

}