<?php
declare(strict_types=1);

namespace Bjyyb\Core\Aspect;


use Bjyyb\Core\Constants\GlobalErrorCode;
use Bjyyb\Core\Constants\GlobalStatusCode;
use Bjyyb\Core\Constants\GlobalSuccessCode;
use Bjyyb\Core\Base\BaseException;
use Bjyyb\Core\Response\JsonRpcResponse;
use Bjyyb\Core\Util\LogUtil;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Validation\ValidationException;

/**
 * Note: Rpc服务切面  监听异常
 * Author: nf
 * Time: 2020/10/27 17:33
 */
class RpcServiceAspect extends AbstractAspect
{

    public $annotations = [RpcService::class];

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $response = ApplicationContext::getContainer()->get(JsonRpcResponse::class);
        try {
            $data = $proceedingJoinPoint->process();
            return $response->success($data, GlobalSuccessCode::SUCCESS);
        } catch (ValidationException $e) {
            /** 验证失败 直接抛出错误信息 不需要记录日志 */
            return $response->fail(GlobalStatusCode::VALIDATION_FAIL, $e->validator->errors()->first());
        } catch (BaseException $e) {
            /** 当前为开发环境时 直接将错误信息返给客户端 */
            $message = extract_exception_message($e, $e->getTitle());
            /** 当前为线上环境时 直接将错误信息输出到日志中 并给前端输出友好提示 */
            if (env('APP_ENV', 'dev') !== 'dev') {
                LogUtil::get('http', 'core-default')->error($message);
                $message = GlobalErrorCode::getMessage($e->getCode()) ?? GlobalErrorCode::getMessage(GlobalErrorCode::SERVER_ERROR);
            }
            return $response->fail($e->getCode(), $message);
        } catch (\Throwable $e) {
            /** 当前为开发环境时 直接将错误信息返给客户端 */
            $message = extract_exception_message($e);
            /** 当前为线上环境时 直接将错误信息输出到日志中 并给前端输出友好提示 */
            if (env('APP_ENV', 'dev') !== 'dev') {
                LogUtil::get('http', 'core-default')->error($message);
                $message = GlobalErrorCode::getMessage(GlobalErrorCode::SERVER_ERROR);
            }
            return $response->fail($e->getCode(), $message);
        }
    }
}