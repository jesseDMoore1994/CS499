<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StaffAssignments Controller
 *
 * @property \App\Model\Table\StaffAssignmentsTable $StaffAssignments
 */
class StaffAssignmentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $staffAssignments = $this->paginate($this->StaffAssignments);

        $this->set(compact('staffAssignments'));
        $this->set('_serialize', ['staffAssignments']);
    }

    /**
     * View method
     *
     * @param string|null $id Staff Assignment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $staffAssignment = $this->StaffAssignments->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('staffAssignment', $staffAssignment);
        $this->set('_serialize', ['staffAssignment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $staffAssignment = $this->StaffAssignments->newEntity();
        if ($this->request->is('post')) {
            $staffAssignment = $this->StaffAssignments->patchEntity($staffAssignment, $this->request->data);
            if ($this->StaffAssignments->save($staffAssignment)) {
                $this->Flash->success(__('The staff assignment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The staff assignment could not be saved. Please, try again.'));
            }
        }
        $users = $this->StaffAssignments->Users->find('list', ['limit' => 200]);
        $this->set(compact('staffAssignment', 'users'));
        $this->set('_serialize', ['staffAssignment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Staff Assignment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $staffAssignment = $this->StaffAssignments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $staffAssignment = $this->StaffAssignments->patchEntity($staffAssignment, $this->request->data);
            if ($this->StaffAssignments->save($staffAssignment)) {
                $this->Flash->success(__('The staff assignment has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The staff assignment could not be saved. Please, try again.'));
            }
        }
        $users = $this->StaffAssignments->Users->find('list', ['limit' => 200]);
        $this->set(compact('staffAssignment', 'users'));
        $this->set('_serialize', ['staffAssignment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Staff Assignment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $staffAssignment = $this->StaffAssignments->get($id);
        if ($this->StaffAssignments->delete($staffAssignment)) {
            $this->Flash->success(__('The staff assignment has been deleted.'));
        } else {
            $this->Flash->error(__('The staff assignment could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function import($fileName, $fileType = ".csv", $fields = array(), $options = array())
    {
        if($fileType === ".csv") {
            $this->StaffAssignments->behaviors()->call("importCsv",
                [$fileName,
                    $fields,
                    $options]);
        }else {}
    }

    public function export($fileName, $fileType = ".csv", $fields = array(), $options = array())
    {

        $data = $this->StaffAssignments->find()->all();

        if($fileType === ".csv") {
            $this->StaffAssignments->behaviors()->call("exportCsv",
                [$fileName,
                    $data,
                    $fields,
                    $options]);
        }else {}
    }
}
