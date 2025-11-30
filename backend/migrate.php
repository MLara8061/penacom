<?php
chdir(__DIR__);
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->call('migrate:fresh', ['--seed' => true, '--force' => true]);
echo json_encode(['status' => $status === 0 ? 'success' : 'error', 'code' => $status]);