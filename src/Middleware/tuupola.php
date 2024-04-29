<?php
   

function Tuupola()
{
    return(new Tuupola\Middleware\JwtAuthentication([
        "attribute" => "jwt",
        "secret" => '1',
        "ignore" => ["/user/authenticate", "/api/user/info", "/preguntas"]
    ]));
}