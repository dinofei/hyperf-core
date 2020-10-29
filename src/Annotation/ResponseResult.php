<?php
declare(strict_types=1);

namespace Bjyyb\Core\Annotation;


use Doctrine\Common\Annotations\Annotation\Target;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * Note: 结果包装器注解
 *
 * @Annotation
 * @Target({"METHOD"})
 *
 * Author: nf
 * Time: 2020/10/29 10:20
 */
class ResponseResult extends AbstractAnnotation
{

}