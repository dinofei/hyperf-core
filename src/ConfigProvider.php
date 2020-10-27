<?php

namespace Bjyyb\Core;

use Bjyyb\Core\Aspect\CoreControllerAspect;
use Bjyyb\Core\Exception\Handler\Http\AppExceptionHandler;
use Bjyyb\Core\Exception\Handler\Http\AppValidationExceptionHandler;
use Bjyyb\Core\Exception\Handler\Http\BaseExceptionHandler;
use Hyperf\ExceptionHandler\Listener\ErrorExceptionHandler;

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
            ],
            'aspects' => [
                CoreControllerAspect::class,
            ],
            'exceptions' => [
                'handler' => [
                    'http' => [
                        AppValidationExceptionHandler::class,
                        BaseExceptionHandler::class,
                        AppExceptionHandler::class,
                    ],
                ],
            ],
            'logger' => [
                'core-default' => [
                    'handler' => [
                        'class' => \Monolog\Handler\StreamHandler::class,
                        'constructor' => [
                            'stream' => BASE_PATH . '/runtime/logs/hyperf.log',
                            'level' => \Monolog\Logger::DEBUG,
                        ],
                    ],
                    'formatter' => [
                        'class' => \Monolog\Formatter\LineFormatter::class,
                        'constructor' => [
                            'format' => null,
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
