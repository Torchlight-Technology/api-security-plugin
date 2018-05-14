<?php
namespace ApiGateway\Controller\Component;

use Cake\Controller\Component;

use ReflectionClass;
use ReflectionMethod;

class MethodDiscoveryComponent extends Component
{
    
    /*
     * Completely copied from https://stackoverflow.com/questions/25892594/list-all-controllers-actions-in-cakephp-3
     */
    private function getControllers() 
    {
        $dir = APP.'Controller/';
        $files = scandir($dir);
        $results = [];
        $ignoreList = [
            '.', 
            '..', 
            'Component', 
            'AppController.php',
        ];
        foreach($files as $file){
            if(!in_array($file, $ignoreList)) {
                $controller = explode('.', $file)[0];
                array_push($results, str_replace('Controller', '', $controller));
            }            
        }
        return $results;
    }

    private function getActions($controllerName) 
    {
        $className = 'App\\Controller\\'.$controllerName.'Controller';
        $class = new ReflectionClass($className);
        $actions = $class->getMethods(ReflectionMethod::IS_PUBLIC);
        $results = [];
        $ignoreList = ['beforeFilter', 'afterFilter', 'initialize'];
        foreach($actions as $action){
            if($action->class == $className && !in_array($action->name, $ignoreList)){
                array_push($results, $action->name);
            }   
        }
        return $results;
    }

    public function getResources()
    {
        $controllers = $this->getControllers();
        $resources = [];
        foreach($controllers as $controller){
            $actions = $this->getActions($controller);
            $resources[$controller] = $actions;
        }
        return $resources;
    }

}