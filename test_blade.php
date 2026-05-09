<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::first();
auth()->login($user);

$req = Illuminate\Http\Request::create('/dashboard', 'GET');
$res = app()->handle($req);
echo "Dashboard Status: " . $res->getStatusCode() . "\n";
if ($res->getStatusCode() >= 400) {
    if (method_exists($res, 'exception') && $res->exception) {
        echo "Dashboard Error: " . $res->exception->getMessage() . "\n";
        echo $res->exception->getTraceAsString() . "\n";
    }
}

$req2 = Illuminate\Http\Request::create('/finance', 'GET');
$res2 = app()->handle($req2);
echo "Finance Status: " . $res2->getStatusCode() . "\n";
if ($res2->getStatusCode() >= 400) {
    if (method_exists($res2, 'exception') && $res2->exception) {
        echo "Finance Error: " . $res2->exception->getMessage() . "\n";
        echo $res2->exception->getTraceAsString() . "\n";
    }
}

$req3 = Illuminate\Http\Request::create('/documents', 'GET');
$res3 = app()->handle($req3);
echo "Documents Status: " . $res3->getStatusCode() . "\n";
if ($res3->getStatusCode() >= 400) {
    if (method_exists($res3, 'exception') && $res3->exception) {
        echo "Documents Error: " . $res3->exception->getMessage() . "\n";
        echo $res3->exception->getTraceAsString() . "\n";
    }
}
