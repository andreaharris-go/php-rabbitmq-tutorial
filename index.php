<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;

require __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$application = new Application('Cloud Logging');
$inputDefinition = new InputDefinition([]);
$application->add(new Command('hello'))
    ->setDefinition($inputDefinition)
    ->setDescription('Hi how are you?')
    ->addArgument(
        'message',
        InputArgument::OPTIONAL,
        'Display message <string>',
        'Hello'
    )
    ->setCode(function ($input, $output) {
        printf("%s\n", $input->getArgument('message'));
    });

$application->add(new Command('simple-exchange'))
    ->setDefinition($inputDefinition)
    ->setCode(function ($input, $output) {
        printf("sending to rabbitMQ\n");
        simpleExchange();
    });

$application->run();