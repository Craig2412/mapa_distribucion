<?php
   

function Tuupola()
{
    return(new Tuupola\Middleware\JwtAuthentication([
        "attribute" => "jwt",
        "secret" => 's',
        "ignore" => ["/api/user/authenticate", "/api/user/info"]
    ]));
}