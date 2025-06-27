<?php

namespace Tests\Feature\Controllers\PostController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_posts()
    {
        $this->getJson(route('posts.index'))->assertOk();
    }
}
