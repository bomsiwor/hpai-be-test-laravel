<?php

it('return hello world',function(){
    $response = $this->get("/api/hello");

    $response->assertStatus(200);
});
