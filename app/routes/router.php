<?php

function load(string $controller, string $action)
{
    //o try catch filtra e só exibe a msg de erro
    try
    {
        $controllerNamespace = "app\\controllers\\{$controller}";
        //var_dump($controller);
        //verificando se o controller existe
        if(!class_exists($controllerNamespace))
        {
            throw new Exception("O controller {$controllerNamespace} não existe!");
        }

        $controllerIstance = new $controllerNamespace();

        //verificando se o metodo existe
        if(!method_exists($controllerIstance, $action))
        {
            throw new Exception("O metodo {$action} não existe no controller {$controller}!");
        }

        $controllerIstance -> $action((object) $_REQUEST);

    }catch(Exception $e)
    {
        echo $e->getMessage();
    }
}

$router = [
    //criação do GET -> Home, Contact e Faq
    //usar arrow function para não precisar dar um echo na rota no index.php
    'GET' => [
        '/' => fn() => load("HomeController", "index"),
        '/contact' => fn() => load("ContactController", "index"),
        '/faq' => fn() => load("FaqController", "index")
    ],

    //criação do POST -> Contact
    'POST' => [
        '/contact' => fn() => load("ContactController", "store"),
    ],
];
