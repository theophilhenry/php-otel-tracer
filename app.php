<?php

require __DIR__ . './vendor/autoload.php';

use GuzzleHttp\Client;
use OpenTelemetry\Contrib\Otlp\OtlpHttpTransportFactory;
use OpenTelemetry\Contrib\Otlp\SpanExporter;
use OpenTelemetry\SDK\Common\Attribute\Attributes;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;

$transport = (new OtlpHttpTransportFactory())->create('http://otelcollector.domain.com/v1/traces', 'application/x-protobuf');
// $transport = (new OtlpHttpTransportFactory())->create('http://localhost:4318/v1/traces', 'application/x-protobuf');
// $transport = (new OtlpHttpTransportFactory())->create('http://otelcollector.kube.local/v1/traces', 'application/x-protobuf');

$tracerProvider =  new TracerProvider(
    new SimpleSpanProcessor(
        new SpanExporter($transport)
    )
);
$tracer = $tracerProvider->getTracer('io.signoz.php.example');

$root = $span = $tracer->spanBuilder('root')->startSpan();
print('root');
$scope = $span->activate();

for ($i = 0; $i < 20; $i++) {
// $i = 0;
// while (true) {
    // $i++;
    print($i);
    sleep(1);
    // 35 detik
    // start a span, register some events
    $span = $tracer->spanBuilder('span-' . $i)->startSpan();

    $span->setAttribute('remote_ip', '1.2.3.4')
        ->setAttribute('country', 'USA');
        // ->setAttribute('service.name', 'NasiGoreng');

    $span->addEvent('found_login' . $i, [
        'id' => $i,
        'username' => 'otuser' . $i,
    ]);
    $span->addEvent('generated_session', [
        'id' => md5((string) microtime(true)),
    ]);

    $span->end();
}

$root->end();
$scope->detach();
echo PHP_EOL . 'OTLPExample complete!  ';

echo PHP_EOL;