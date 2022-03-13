<?php declare(strict_types=1);

namespace App\Container\Exceptions;

use Psr\Container\ContainerExceptionInterface;

class ContainerException extends \Exception implements ContainerExceptionInterface
{
}