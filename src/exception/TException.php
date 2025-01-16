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
     * @var array
     */
    private $headers;

    public function __construct(int $statusCode, string $message = '', Exception $previous = null, array $headers = [], $code = 0)
    {
        $this->setHeaders($headers);

        /** message */
        if(empty($message)) $message = StatusCode::$status_code[$statusCode] ?? StatusCode::$status_code[StatusCode::COMMON_UNKNOWN];
        parent::__construct('ERROR tinymeng tools: '.$message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return TException
     */
    public function setHeaders(array $headers): TException
    {
        $this->headers = $headers;
        return $this;
    }
}
