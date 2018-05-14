<?php
namespace ApiGateway\Model\Entity;

use Cake\ORM\Entity;

/**
 * EndPoint Entity
 *
 * @property int $id
 * @property string $controller
 * @property string $method
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class EndPoint extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'controller' => true,
        'method' => true,
        'created' => true,
        'modified' => true
    ];
}
