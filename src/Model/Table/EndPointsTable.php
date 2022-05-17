<?php
namespace ApiGateway\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Cache\Cache;

/**
 * EndPoints Model
 *
 * @method \ApiGateway\Model\Entity\EndPoint get($primaryKey, $options = [])
 * @method \ApiGateway\Model\Entity\EndPoint newEntity($data = null, array $options = [])
 * @method \ApiGateway\Model\Entity\EndPoint[] newEntities(array $data, array $options = [])
 * @method \ApiGateway\Model\Entity\EndPoint|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \ApiGateway\Model\Entity\EndPoint patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \ApiGateway\Model\Entity\EndPoint[] patchEntities($entities, array $data, array $options = [])
 * @method \ApiGateway\Model\Entity\EndPoint findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EndPointsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('end_points');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('controller')
            ->maxLength('controller', 64)
            ->requirePresence('controller', 'create')
            ->notEmptyString('controller');

        $validator
            ->scalar('method')
            ->maxLength('method', 64)
            ->requirePresence('method', 'create')
            ->notEmptyString('method');

        return $validator;
    }

    public function getApiMethods(string $controller) {

        $results = Cache::read($controller, 'methods');

        if(!$results) {
            $results = $this->find('list', [
                'valueField' => 'method'
                ])
                ->where(['controller' => $controller])
                ->toArray();

            $results = array_values($results);

            Cache::write($controller, $results, 'methods');
        }

        return $results;
    }

    public function isMethodProtected($controller, $method) {

        $protectedMethods = $this->getApiMethods($controller);
        //debug($protectedMethods);
        return array_search($method, $protectedMethods) !== false;
    }
}
