<?php

use function Pest\Laravel\get;

it('displays welcome page', function () {
    $response = get('/');

    $response->assertStatus(200)->assertSee('antihq/board');
});
