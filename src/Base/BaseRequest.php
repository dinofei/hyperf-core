<?php
declare(strict_types=1);

namespace Bjyyb\Core\Base;


use Hyperf\Contract\ValidatorInterface;
use Hyperf\Utils\ApplicationContext;
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
     * @return ValidatorInterface
     * Author: nf
     * Time: 2020/10/27 19:15
     */
    public static function validate(array $data): ValidatorInterface
    {
        /** @var ValidatorInterface $validator */
        $validator = ApplicationContext::getContainer()->get(static::class)->getValidatorInstance();
        $validator->setData($data)->validate();
        return $validator;
    }
}