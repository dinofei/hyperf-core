<?php
declare(strict_types=1);

namespace Bjyyb\Core\Aspect;


use Bjyyb\Core\Constants\ErrorCode;
use Bjyyb\Core\Exception\BaseException;
use Bjyyb\Core\DataStructure\Result;
use Bjyyb\Core\Util\LogUtil;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\Validation\ValidationException;

/**
 * Note: Rpc服务切面 包装返回结果
 * Author: nf
 * Time: 2020/10/27 17:33
 */
class RpcServiceAspect extends AbstractAspect
{

    public $annotations = [RpcService::class];

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        try {
            $data = $proceedingJoinPoint->process();
            $result = Result::success($data);
        } catch (ValidationException $e) {
            /** 参数验证失败时，不需要记录日志，只要把错误信息返回客户端即可 */
            $result = Result::fail(ErrorCode::PARAM_VALIDATE_ERROR, $e->validator->errors()->first());
        } catch (BaseException $e) {
            /** 业务逻辑异常，不需要记录日志，直接将错误信息返给客户端 */
            $result = Result::fail($e->getCode(), $e->getMessage());
        } catch (\Throwable $e) {
            /** 代码异常或者未被捕获的其他异常 直接将错误信息返给客户端 */
            /** 当前为开发环境时  */
            $message = extract_exception_message($e);
            $code = ErrorCode::SERVER_ERROR;
            if (env('APP_ENV', 'dev') !== 'dev') {
                /** 当前为线上环境时，将错误信息同时保存在日志中 */
                LogUtil::get('http', 'core-default')->error($message);
            }
            $result = Result::fail($code, $message);
        }
        return $result;
    }
}