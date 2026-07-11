<?php

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response
        ->assertStatus(200)
        ->assertSee('Bahasa Inggris')
        ->assertSee('Bahasa Korea')
        ->assertSee('Bahasa Jepang')
        ->assertSee('Ms Adel');
});
