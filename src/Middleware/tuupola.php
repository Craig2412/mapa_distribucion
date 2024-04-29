<?php
   

function Tuupola()
{
    return(new Tuupola\Middleware\JwtAuthentication([
        "attribute" => "jwt",
        "secret" => '1',
        "ignore" => ["/auth/user/authentication", "/user/create", "/preguntas" , "/funcionarios/create", "/funcionarios/unico"]
    ]));
}