<?php
namespace tinymeng\tools\exception;

use Exception;

/**
 * Class TException
 * @package tinymeng\tools\exception
 * @Author: TinyMeng <666@majiameng.com>
 * @Created: 2020/8/17
 */
class TException extends \Exception
{
    /**
     * @var int
     */
    private $headers;

    public function __construct(int $statusCode, string $message = '', Exception $previous = null, array $headers = [], $code = 0)
    {
        $this->headers    = $headers;

        /** message */
        if(empty($message)) $message = isset(StatusCode::$status_code[$statusCode]) ? StatusCode::$status_code[$statusCode] :StatusCode::$status_code[StatusCode::COMMON_UNKNOWN];
        parent::__construct('ERROR_TINYMENG_TOOL: '.$message, $code, $previous);
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
