<?php

$router = $di->getRouter();

// Define your routes here
$router->add('/patients/api', [
  'controller' => 'patient',
  'action' => 'getPatients',
  'methods' => ['GET'],
]);

$router->add('/patients/api/create', [
  'controller' => 'patient',
  'action' => 'createPatient',
  'methods' => ['POST'],
]);

$router->add('/patients/api/{id:[0-9]+}', [
  'controller' => 'patient',
  'action' => 'getPatientById',
  'methods' => ['GET'],
]);

$router->add('/patients/api/update/{id:[0-9]+}', [
  'controller' => 'patient',
  'action' => 'updatePatient',
  'methods' => ['PUT'],
]);

$router->add('/patients/api/delete/{id:[0-9]+}', [
  'controller' => 'patient',
  'action' => 'deletePatient',
  'methods' => ['DELETE'],
]);

$router->handle($_SERVER['REQUEST_URI']);
