# Piper

**Piper** enhances the PHP 8.5 pipe operator (``|>``) with support for multi-argument functions/callables.

[![CI](https://github.com/Burnett01/piper/actions/workflows/tests.yml/badge.svg)](https://github.com/Burnett01/piper/actions/workflows/tests.yml)

<img src=".github/piper-logo.png" alt="Piper Logo" width="300" align="right"/>

**Background**

In PHP the pipe operator (``|>``) works with single-argument callables, such as ``strlen``, ``trim``, etc..,<br>

```php
$nonce = random_bytes(16)
      |> base64_encode(...);       
```

but what if you want to use it with multi-argument callables, such as ``rtrim``, ``strtr``, etc..

```php
// does not work
$nonce = random_bytes(16)
      |> base64_encode(...)
      |> strtr(..., '+/', '-_')
      |> rtrim(..., '=');       
```

```php
// works but too verbose
$nonce = random_bytes(16)
      |> base64_encode(...)
      |> (fn(string $s): string => strtr($s, '+/', '-_'))
      |> (fn($s) => rtrim($s, '='));    
```

This is where **Piper** comes into play!

## How it works

**Piper** is sort of a decorator/wrapper around a callable for the pipe operator ``|>``.

### Example

```php
use Burnett01\Piper\Piper as pipe;

$nonce = random_bytes(16)
      |> base64_encode(...)
      |> pipe::to('strtr', '+/', '-_')
      // or use 'with'
      |> pipe::with(rtrim(...), '=');       
```

The ellipsis ``...`` represents the first-class callable syntax.

You can use a ``callable`` as string or first-class syntax for passing the method.

## Usage

> ``composer require burnett01/piper``

```php
use Burnett01\Piper\Piper as pipe;

$nonce = random_bytes(16)
      |> base64_encode(...)
      |> pipe::to('strtr', '+/', '-_')
      // with first-class syntax
      |> pipe::to(rtrim(...), '=');       
```

or use ``with`` alias

```php
use Burnett01\Piper\Piper as pipe;

$actual = -1234.5
      |> abs(...)
      |> pipe::with(number_format(...), 2, '.', ',')
      |> urlencode(...);
```

## Api

#### ``Piper::to(callable $fn, mixed ...$args)``

Creates an instance of Piper for the specificed ``$fn``.

Parameters:

- callable ``$fn`` - The name of a callable as string (eg. ``'strlen'``) or as first-class syntax (eg. ``strlen(...)``)

- variadic (mixed) ``$args`` - The arguments for ``$fn``

Context: static

Returns: instance

#### ``Piper::with(callable $fn, mixed ...$args)``

alias for ``Piper::to(callable $fn, mixed ...$args)`` (see above)
