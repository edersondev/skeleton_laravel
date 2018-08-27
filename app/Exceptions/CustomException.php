<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Exception;

class CustomException extends Exception
{
  /**
   * Default value: danger
   * Options: success, warning, info
   */
  private $typeMessage;

  private $exceptionMessage;

  /**
   * CustomException constructor.
   *
   * @param string $message
   * @param int    $code
   * @param null   $previous
   */
  public function __construct($message, $code = 0, $typeMessage = 'danger', $previous = null)
  {
    $this->typeMessage = $typeMessage;
    $this->exceptionMessage = $this->getExceptionMessage($message, $code);
    parent::__construct($this->exceptionMessage, $code, $previous);
  }

  public function report()
  {
  }

  public function render(Request $request)
  {
  }

  public function getTypeMessage()
  {
    return $this->typeMessage;
  }

  private function getExceptionMessage($message, $code)
  {
    if( env('APP_DEBUG') === false && $code !== 0 ){
      return trans('messages.error_exception');
    }
    return $message;
  }
}