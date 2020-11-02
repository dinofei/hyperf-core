<?php

namespace Bjyyb\Core;

use Bjyyb\Core\Exception\Handler\Http\AppExceptionHandler;
use Bjyyb\Core\Exception\Handler\Http\ValidationExceptionHandler;
use Bjyyb\Core\Listener\DbQueryExecutedListener;
use Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler;
use Hyperf\Validation\Middleware\ValidationMiddleware;

class ConfigProvider
{
    public function __invoke(): array
    {
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
                        AppExceptionHandler::class,
                    ],
                ],
            ],
            'logger' => [
                'default' => [
                    'handler' => [
                        'class' => \Monolog\Handler\RotatingFileHandler::class,
                        'constructor' => [
                            'filename' => env('LOG_PATH', BASE_PATH . '/runtime/logs') . '/default/hyperf.log',
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
                            'filename' => env('LOG_PATH', BASE_PATH . '/runtime/logs') . '/default/hyperf.log',
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
