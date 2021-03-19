<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected string $editorToken = "pAEv5zPtXT5sMll8SuW9KkY5dQRg8OnaLIsFGVEk";
    protected string $adminToken = "hstIygEutGVFzqWq1eEXi3R6b0yEsqfEAQFCI8Lc";
    use CreatesApplication;
}
