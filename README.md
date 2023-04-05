# PHP OpenTelemetry Tracer
> The full explanation of using this App to send traces to SigNoz on K8s can be seen on this article : [Rook-Ceph K8s Hands-On: Study Case SigNoz + ClickHouse](https://medium.com/@theophil730730/rook-ceph-k8s-hands-on-study-case-signoz-clickhouse-fb9ad1417815)

This repo contains one PHP application that is able to produce traces to OpenTelemetry App.

---
<br><br>
# Using the Application

## Prerequisites
1. PHP 8.1.12
2. Composer version 2.4.4
<br><br>

## Install Composer Dependencies
To installa all the dependencies needed for the app to run, do the following command.
```shell
composer install
```

## Start the App
To start sending traces to Otel app, do the following command.
```shell
php ./app.php
```