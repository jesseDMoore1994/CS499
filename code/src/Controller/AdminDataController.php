<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\ORM\TableRegistry;
use CakePHPCSV\Model\Behavior\CsvBehavior;

class AdminDataController extends AdminController
{
    public function index()
    {

    }

    public function import()
    {
        if($this->request->is('post')):
        {
            if($this->request->data['submissionFile'] == ''): {
                $this->set('file_status', 'No file submitted, try again.');
            }elseif($this->request->data['submissionFile']): {
                $this->set('file_status', 'File submitted.');
                Debugger::dump($this->request->data['submissionFile']);
                Debugger::dump($this->request->data['table']);
                if($this->request->data['table'] == 0): //table is tickets
                {
                    Debugger::dump($this->request->data['submissionFile']);


                }elseif($this->request->data['table'] == 1): //table is staff assignments
                {

                }elseif($this->request->data['table'] == 2): //table is users
                {

                }else:
                {
                    $this->Flash->error('Unexpected table value');
                }endif;
                $this->Flash->success('File successfully uploaded, Importing...');
            }else: {
                $this->set('file_status', 'Please submit a file.');
            }endif;
        }
        else:
        {
            $this->set('file_status', 'Please submit a file.');
        } endif;

    }

    public function export($tableVal = null, $informationVal = null, $format = null)
    {

    }
}