<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class PatientController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        //
    }

    /**
     * Searches for patient
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Patient', $_GET)->getParams();
        $parameters['order'] = "id";

        $paginator   = new Model(
            [
                'model'      => 'Patient',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any patient");

            $this->dispatcher->forward([
                "controller" => "patient",
                "action" => "index"
            ]);

            return;
        }

        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        //
    }

    /**
     * Edits a patient
     *
     * @param string $id
     */
    public function editAction($id)
    {
        if (!$this->request->isPost()) {
            $patient = Patient::findFirstByid($id);
            if (!$patient) {
                $this->flash->error("patient was not found");

                $this->dispatcher->forward([
                    'controller' => "patient",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->id = $patient->id;

            $this->tag->setDefault("id", $patient->id);
            $this->tag->setDefault("name", $patient->name);
            $this->tag->setDefault("sex", $patient->sex);
            $this->tag->setDefault("religion", $patient->religion);
            $this->tag->setDefault("phone", $patient->phone);
            $this->tag->setDefault("address", $patient->address);
            $this->tag->setDefault("nik", $patient->nik);
            
        }
    }

    /**
     * Creates a new patient
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "patient",
                'action' => 'index'
            ]);

            return;
        }

        $patient = new Patient();
        $patient->name = $this->request->getPost("name");
        $patient->sex = $this->request->getPost("sex");
        $patient->religion = $this->request->getPost("religion");
        $patient->phone = $this->request->getPost("phone");
        $patient->address = $this->request->getPost("address");
        $patient->nik = $this->request->getPost("nik");
        

        if (!$patient->save()) {
            foreach ($patient->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "patient",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("patient was created successfully");

        $this->dispatcher->forward([
            'controller' => "patient",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a patient edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "patient",
                'action' => 'index'
            ]);

            return;
        }

        $id = $this->request->getPost("id");
        $patient = Patient::findFirstByid($id);

        if (!$patient) {
            $this->flash->error("patient does not exist " . $id);

            $this->dispatcher->forward([
                'controller' => "patient",
                'action' => 'index'
            ]);

            return;
        }

        $patient->name = $this->request->getPost("name");
        $patient->sex = $this->request->getPost("sex");
        $patient->religion = $this->request->getPost("religion");
        $patient->phone = $this->request->getPost("phone");
        $patient->address = $this->request->getPost("address");
        $patient->nik = $this->request->getPost("nik");
        

        if (!$patient->save()) {

            foreach ($patient->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "patient",
                'action' => 'edit',
                'params' => [$patient->id]
            ]);

            return;
        }

        $this->flash->success("patient was updated successfully");

        $this->dispatcher->forward([
            'controller' => "patient",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a patient
     *
     * @param string $id
     */
    public function deleteAction($id)
    {
        $patient = Patient::findFirstByid($id);
        if (!$patient) {
            $this->flash->error("patient was not found");

            $this->dispatcher->forward([
                'controller' => "patient",
                'action' => 'index'
            ]);

            return;
        }

        if (!$patient->delete()) {

            foreach ($patient->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "patient",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("patient was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "patient",
            'action' => "index"
        ]);
    }

    public function getPatientsAction()
    {
        $patients = Patient::find();
        $response = [
            'status' => [
                'code' => 200,
                'response' => 'success',
                'message' => 'Success fetch patients'
            ],
            'result' => $patients
        ];
        return $this->response->setJsonContent($response);
    }

    public function createPatientAction()
    {
        $jsonData = $this->request->getJsonRawBody();
        $patient = new Patient();
        $patient->name = $jsonData->name;
        $patient->sex = $jsonData->sex;
        $patient->religion = $jsonData->religion;
        $patient->phone = $jsonData->phone;
        $patient->address = $jsonData->address;
        $patient->nik = $jsonData->nik;
        $patient->save();

        $response = [
            'status' => [
                'code' => 201,
                'response' => 'success',
                'message' => 'Patient created'
            ],
            'result' => $patient
        ];

        return $this->response->setJsonContent($response)->setStatusCode(201);
    }


    public function getPatientByIdAction()
    {
        $id = $this->dispatcher->getParam('id');
        $patient = Patient::findFirstByid($id);

        if (!$patient) {
            $response = [
                'status' => [
                    'code' => 404,
                    'response' => 'failed',
                    'message' => 'Data not found'
                ],
                'result' => null
            ];
            return $this->response->setJsonContent($response)->setStatusCode(404);
        }

        $response = [
            'status' => [
                'code' => 200,
                'response' => 'success',
                'message' => 'Success fetch patient detail'
            ],
            'result' => $patient
        ];
        return $this->response->setJsonContent($response);
    }

    public function updatePatientAction()
    {
        $id = $this->dispatcher->getParam('id');
        $patient = Patient::findFirstByid($id);
        if (!$patient) {
            $response = [
                'status' => [
                    'code' => 404,
                    'response' => 'failed',
                    'message' => 'Data not found'
                ],
                'result' => null
            ];
            return $this->response->setJsonContent($response)->setStatusCode(404);
        }

        $jsonData = $this->request->getJsonRawBody();
        $patient->name = $jsonData->name ?? $patient->name;
        $patient->sex = $jsonData->sex ?? $patient->sex;
        $patient->religion = $jsonData->religion ?? $patient->religion;
        $patient->phone = $jsonData->phone ?? $patient->phone;
        $patient->address = $jsonData->address ?? $patient->address;
        $patient->nik = $jsonData->nik ?? $patient->nik;
        $patient->save();

        $response = [
            'status' => [
                'code' => 200,
                'response' => 'success',
                'message' => 'Patient updated'
            ],
            'result' => $patient
        ];
        return $this->response->setJsonContent($response);
    }

    public function deletePatientAction()
    {
        $id = $this->dispatcher->getParam('id');
        $patient = Patient::findFirstByid($id);
        if (!$patient) {
            $response = [
                'status' => [
                    'code' => 404,
                    'response' => 'failed',
                    'message' => 'Data not found'
                ],
                'result' => null
            ];
            return $this->response->setJsonContent($response)->setStatusCode(404);
        }
        $patient->delete();

        $response = [
            'status' => [
                'code' => 200,
                'response' => 'success',
                'message' => 'Patient deleted'
            ],
            'result' => $patient
        ];
        return $this->response->setJsonContent($response);
    }
}
