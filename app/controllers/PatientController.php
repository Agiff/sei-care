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
}
