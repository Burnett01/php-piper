<?php
declare(strict_types=1);

namespace Burnett01\Piper;

function pipe(callable $fn, mixed ...$args): Piper
{
    return Piper::to($fn, ...$args);
}

function with(callable $fn, mixed ...$args): Piper
{
    return Piper::to($fn, ...$args);
}
