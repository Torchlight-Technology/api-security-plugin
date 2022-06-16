<?php
namespace ApiGateway\Controller;

use ApiGateway\Controller\AppController;
use Cake\Cache\Cache;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;

/**
 * EndPoints Controller
 *
 *
 * @method \ApiGateway\Model\Entity\EndPoint[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EndPointsController extends AppController
{


    public function initialize(): void {
        parent::initialize();
        $this->loadComponent('ApiGateway.MethodDiscovery');
    }

    public function clearCache(string $group, string $config = 'api-keys') {
        Cache::clearGroup($group, $config);
        $this->Flash->success(__('The cache has been cleared.'));
        $this->redirect(['action' => 'index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(): void
    {
        $endPoints = $this->paginate($this->EndPoints);

        $this->set(compact('endPoints'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if ($this->request->is('post')) {

            // Delete existing
            $this->EndPoints->deleteAll([]);
            // clear methods cache
            Cache::clearGroup('methods', 'methods');

            $request = $this->request->getData();
            $data = [];
            foreach($request['methods'] as $controllerName => $actionNames) {
                foreach($actionNames as $actionName => $value) {
                    if($value) {
                        $data[] = [
                            'controller' => $controllerName,
                            'method' => $actionName
                        ];
                    }
                }

            }

            if(!empty($data)) {
                $endPoints = $this->EndPoints->newEntities($data);
                if ($this->EndPoints->saveMany($endPoints)) {
                    $this->Flash->success(__('The end points has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The end point could not be saved. Please, try again.'));
            }
            else {
                $this->Flash->error(__('The end points were removed.'));
                return $this->redirect(['action' => 'index']);
            }
        }

        $resources = $this->MethodDiscovery->getResources();
        $endPoints = $this->EndPoints->find('list', [
            'keyField' => 'method',
            'groupField' => 'controller'
        ])->toArray();

        $this->set(compact('resources', 'endPoints'));
    }


    /**
     * Delete method
     *
     * @param string|null $id End Point id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $endPoint = $this->EndPoints->get($id);
        if ($this->EndPoints->delete($endPoint)) {
            // clear methods cache
            Cache::clearGroup('methods', 'methods');
            $this->Flash->success(__('The end point has been deleted.'));
        } else {
            $this->Flash->error(__('The end point could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
