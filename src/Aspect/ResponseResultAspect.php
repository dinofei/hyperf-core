<?php
declare(strict_types=1);

namespace Bjyyb\Core\Aspect;


use Bjyyb\Core\Annotation\ResponseResult;
use Bjyyb\Core\Constants\StatusCode;
use Bjyyb\Core\DataStructure\Result;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\ApplicationContext;

/**
 * Note: 结果包装器注解切面 统一拦截响应json格式数据
 *
 * @Aspect()
 *
 * Author: nf
 * Time: 2020/10/29 10:21
 */
class ResponseResultAspect extends AbstractAspect
{

    public $annotations = [ResponseResult::class];

    /**
     * @inheritDoc
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $statusCode = StatusCode::SUCCESS;
        $data = $proceedingJoinPoint->process();
        $result = Result::success($data);
        return ApplicationContext::getContainer()
            ->get(ResponseInterface::class)
            ->withStatus($statusCode)
            ->json($result->toArray());
    }
}