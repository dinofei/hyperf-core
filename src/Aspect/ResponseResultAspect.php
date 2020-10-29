<?php
declare(strict_types=1);

namespace Bjyyb\Core\Aspect;


use Bjyyb\Core\Annotation\ResponseResult;
use Bjyyb\Core\Base\BaseException;
use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\Constants\StatusCode;
use Bjyyb\Core\DataStructure\Result;
use Bjyyb\Core\Util\LogUtil;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Validation\ValidationException;

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
        try {
            $data = $proceedingJoinPoint->process();
            $result = Result::success($data);
        } catch (ValidationException $e) {
            /** 参数验证失败时，不需要记录日志，只要把错误信息返回客户端即可 */
            $statusCode = StatusCode::PARAM_ERROR;
            $result = Result::fail(ErrorCode::PARAM_VALIDATE_ERROR, $e->validator->errors()->first());
        } catch (BaseException $e) {
            /** 业务逻辑异常，不需要记录日志，直接将错误信息返给客户端 */
            $statusCode = StatusCode::Fail;
            $result = Result::fail($e->getCode(), $e->getMessage());
        } catch (\Throwable $e) {
            /** 代码异常或者未被捕获的其他异常 */
            /** 当前为开发环境时 直接将错误信息返给客户端 */
            $statusCode = StatusCode::SERVER_ERROR;
            $message = extract_exception_message($e);
            $code = ErrorCode::SERVER_ERROR;
            if (env('APP_ENV', 'dev') !== 'dev') {
                /** 当前为线上环境时，将错误信息输出到日志中 并给前端输出友好提示 */
                LogUtil::get('http', 'core-default')->error($message);
                $message = ErrorCode::getMessage($code);
            }
            $result = Result::fail($code, $message);
        }
        return ApplicationContext::getContainer()
            ->get(ResponseInterface::class)
            ->withStatus($statusCode)
            ->json($result->toArray());
    }
}