<?php

namespace Bjyyb\Core;

use Bjyyb\Core\Exception\Handler\Http\AppExceptionHandler;
use Bjyyb\Core\Exception\Handler\Http\BaseExceptionHandler;
use Bjyyb\Core\Exception\Handler\Http\RpcClientExceptionHandler;
use Bjyyb\Core\Exception\Handler\Http\ValidationExceptionHandler;
use Bjyyb\Core\Exception\Handler\JsonRpc\AppExceptionHandler as JsonRpcAppExceptionHandler;
use Bjyyb\Core\Exception\Handler\JsonRpc\BaseExceptionHandler as JsonRpcBaseExceptionHandler;
use Bjyyb\Core\Exception\Handler\JsonRpc\ValidationExceptionHandler as JsonRpcValidationExceptionHandler;
use Bjyyb\Core\Listener\DbQueryExecutedListener;
use Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler;
use Hyperf\Validation\Middleware\ValidationMiddleware;

class ConfigProvider
{
    public function __invoke(): array
    {
        /** 手动引入自定义函数文件 */
        require_once __DIR__ . '/Function/common.php';

        return [
            'dependencies' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'commands' => [],
            'listeners' => [
                ErrorExceptionHandler::class,
                DbQueryExecutedListener::class,
            ],
            'aspects' => [
            ],
            'middlewares' => [
                'http' => [
                    ValidationMiddleware::class,
                ],
            ],
            'exceptions' => [
                'handler' => [
                    'http' => [
                        ValidationExceptionHandler::class,
                        BaseExceptionHandler::class,
                        RpcClientExceptionHandler::class,
                        AppExceptionHandler::class,
                    ],
                    'jsonrpc' => array(
                        JsonRpcValidationExceptionHandler::class,
                        JsonRpcBaseExceptionHandler::class,
                        JsonRpcAppExceptionHandler::class,
                    ),
                ],
            ],
            'logger' => [
                'default' => [
                    'handler' => [
                        'class' => \Monolog\Handler\RotatingFileHandler::class,
                        'constructor' => [
                            'filename' => env('LOG_PATH', BASE_PATH . '/runtime/logs') . '/default/debug.log',
                            'level' => \Monolog\Logger::DEBUG,
                        ],
                    ],
                    'formatter' => [
                        'class' => \Monolog\Formatter\LineFormatter::class,
                        'constructor' => [
                            'format' => "%datetime% %level_name% %message% %context% %extra%\n",
                            'dateFormat' => 'Y-m-d H:i:s',
                            'allowInlineLineBreaks' => true,
                        ],
                    ],
                ],
                'core-default' => [
                    'handler' => [
                        'class' => \Monolog\Handler\RotatingFileHandler::class,
                        'constructor' => [
                            'filename' => env('LOG_PATH', BASE_PATH . '/runtime/logs') . '/default/error.log',
                            'level' => \Monolog\Logger::ERROR,
                        ],
                    ],
                    'formatter' => [
                        'class' => \Monolog\Formatter\LineFormatter::class,
                        'constructor' => [
                            'format' => "%datetime% %channel% %level_name% %message% %context% %extra%\n",
                            'dateFormat' => 'Y-m-d H:i:s',
                            'allowInlineLineBreaks' => true,
                        ],
                    ],
                ],
                'core-sql' => [
                    'handler' => [
                        'class' => \Monolog\Handler\RotatingFileHandler::class,
                        'constructor' => [
                            'filename' => env('LOG_PATH', BASE_PATH . '/runtime/logs') . '/sql/sql.log',
                            'level' => \Monolog\Logger::ERROR,
                        ],
                    ],
                    'formatter' => [
                        'class' => \Monolog\Formatter\LineFormatter::class,
                        'constructor' => [
                            'format' => "%datetime% %level_name% %message% %context% %extra%\n",
                            'dateFormat' => 'Y-m-d H:i:s',
                            'allowInlineLineBreaks' => true,
                        ],
                    ],
                ],
                'core-std' => [
                    'handler' => [
                        'class' => \Monolog\Handler\StreamHandler::class,
                        'constructor' => [
                            'stream' => 'php://stdout',
                            'level' => \Monolog\Logger::DEBUG,
                        ],
                    ],
                    'formatter' => [
                        'class' => \Monolog\Formatter\LineFormatter::class,
                        'constructor' => [
                            'format' => "||%datetime%||%channel%||%level_name%||%message%||%context%||%extra%\n",
                            'allowInlineLineBreaks' => true,
                            'includeStacktraces' => true,
                        ],
                    ],
                ],
            ],
//            'publish' => [
//                [
//                    'id' => 'config',
//                    'description' => 'description of this config file.',
//                    'source' => __DIR__ . '/../publish/file.php',
//                    'destination' => BASE_PATH . '/config/autoload/file.php',
//                ],
//            ],
        ];
    }
}
