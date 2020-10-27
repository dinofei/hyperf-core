<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;


use Hyperf\Validation\Request\FormRequest;

/**
 * Note: 验证器基类
 * Author: nf
 * Time: 2020/10/27 19:13
 */
class BaseRequest extends FormRequest
{
    protected function authorize()
    {
        return true;
    }

    /**
     * 手动传入数据验证
     * @param array $data
     * @return mixed
     * Author: nf
     * Time: 2020/10/27 19:15
     */
    public function validate(array $data)
    {
        return $this->getValidatorInstance()->setData($data)->validate();
    }
}