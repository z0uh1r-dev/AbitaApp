<?php

test('home page redirects to admin dashboard', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('admin.dashboard'));
});
