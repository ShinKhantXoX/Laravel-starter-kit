<?php

namespace Tests;

use App\Traits\JsonResponder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use JsonResponder;
}
