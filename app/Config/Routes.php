<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('dashboard', 'Dashboard::index');
$routes->get('/', 'Dashboard::index');

$routes->get('data-pegawai', 'Sipedok::dataPegawai');

$routes->get('monitoring-dokumen', 'Sipedok::monitoringDokumen');

$routes->get('tindak-lanjut', 'Sipedok::tindakLanjut');