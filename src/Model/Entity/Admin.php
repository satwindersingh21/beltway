<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Admin Entity
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $forgot_password_token
 * @property string $profile_image
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Admin extends Entity {
    
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
        'name' => true,
        'email' => true,
        'password' => true,
        'role' => true,
        'forgot_password_token' => true,
        'profile_image' => true,
        'created' => true,
        'modified' => true
    ];
    
    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
    
    protected function _setPassword($password) {
        return (new DefaultPasswordHasher)->hash($password);
    }
}