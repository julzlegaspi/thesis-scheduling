<?php

test('user will redirect to facebook', function () {
    $response = $this->get('/facebook/redirect');

    $response->assertStatus(302);
});