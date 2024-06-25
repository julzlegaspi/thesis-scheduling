<?php

test('user will redirect to google', function () {
    $response = $this->get('/google/redirect');

    $response->assertStatus(302);
});