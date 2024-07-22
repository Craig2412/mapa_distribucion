<?php
   

function Tuupola()
{
    return(new Tuupola\Middleware\JwtAuthentication([
        "attribute" => "jwt",
        "secret" => '1',
        "secure" => true,
        "ignore" => ["/auth/user/authentication", "/user/create", "/encuesta" , "/preguntas" , "/funcionarios/create", "/funcionarios/unico","/funcionarios/update/"]
    ]));
}