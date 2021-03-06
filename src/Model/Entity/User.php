<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $non_governmental_email
 * @property string $password
 * @property $profile_image
 * @property string $city
 * @property string $state
 * @property string $role
 * @property string $type
 * @property bool $registration_steps_done
 * @property string $forgot_password_token
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class User extends Entity {
    
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
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'non_governmental_email' => true,
        'phone_number' => true,
        'password' => true,
        'profile_image' => true,
        'city' => true,
        'state' => true,
        'role' => true,
        'user_type' => true,
        'registration_steps_done' => true,
        'forgot_password_token' => true,
        'active' => true,
        'step_crossed' => true,
        'welcome_token' => true,
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
