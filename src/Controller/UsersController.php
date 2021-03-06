<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['register', 'isUniqueEmail', 'login', 'add', 'forgotPassword', 'forgotPasswordApi', 'resetPassword', 'resetPasswordApi', 'privateCitizenApi']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    
    public function dashboard() {
        $user = $this->Users->find('all')->first();
        $options = [
            'template' => 'welcome',
            'to' => 'satwinder.singh.21@gmail.com',
            'subject' => _('Welcome to ' . SITE_TITLE),
            'viewVars' => [
                'name' => $user->first_name,
                'email' => $user->email,
                'password' => '123456789'
            ]
        ];
        
        $this->loadComponent('EmailManager');
        $this->EmailManager->sendEmail($options);
        
        die('sent');
        
        //if($this->Auth->user('role') == "Politician"){
        //  return $this->redirect(['action' => 'politician']);;
        //} else {
        //  return $this->redirect(['action' => 'privateCitizen']);
        //}
        //Do something
    }
    
    
    /**
     * logout method
     */
    public function logout() {
        $this->Cookie->delete('loggedInUser');
        $this->Flash->success(__('You are now logged out'));
        return $this->redirect($this->Auth->logout());
    }
    
    public function login() {
        //if already logged-in, redirect
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        
        if ($this->request->is('post') || $this->request->query('provider')) {
            $data = $this->request->getData();
            $user = $this->Auth->identify();
            if ($user) {
                if (isset($this->request->data['remember_me'])) {
                    $this->Cookie->write('loggedInUser', $user, true, '1 year');
                }
                $this->Auth->setUser($user);
                $daysOld = $this->dateDiff($user['created']);
                if ($user['registration_steps_done'] || $user['step_crossed'] || $daysOld <= 90) {
                    return $this->redirect($this->Auth->redirectUrl());
                } else {
                    if ($user['role'] == "Politician") {
                        return $this->redirect(['action' => 'politician']);;
                    } else {
                        return $this->redirect(['controller' => 'Articles', 'action' => 'platform']);
                    }
                }
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }
    
    
    /**
     * Register method
     *
     * @return \Cake\Http\Response|null Redirects to Auth Redirect URL.
     */
    public function register() {
        //if already logged-in, redirect
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        
        $usaStates = $this->usaStates();
        $this->set('usaStates', $usaStates);
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $this->request->getData(), ['validate' => 'newUser']);
            
            $password = $this->request->getData('password');
            
            $user->welcome_token = $password;
            
            if ($this->Users->save($user)) {
                
                
                $this->Auth->setUser($user);
                $this->Flash->success(__('You have successfully registered.'));
                
                if ($user->role == "Politician") {
                    return $this->redirect(['action' => 'politician']);;
                } else {
                    return $this->redirect(['action' => 'privateCitizen']);
                }
            } else {
                if (is_array($user->errors())) {
                    foreach ($user->errors() as $errors) {
                        foreach ($errors as $err) {
                            $error = $err;
                        }
                    }
                }
                $this->Flash->error(__($error));
                return $this->redirect(['action' => 'register']);
            }
        }
    }
    
    public function sendWelcomeEmail() {
        
        $user = $this->Users->find('all')->where(['Users.id' => $this->Auth->user('id')])->first();
        if (!empty($user->welcome_token)) {
            $options = [
                'template' => 'welcome',
                'to' => $user->email,
                'subject' => _('Welcome to ' . SITE_TITLE),
                'viewVars' => [
                    'name' => $user->first_name,
                    'email' => $user->email,
                    'password' => $user->welcome_token,
                ]
            ];
            
            $this->loadComponent('EmailManager');
            $this->EmailManager->sendEmail($options);
            
            $this->Users->updateAll(['welcome_token' => ''], ['Users.id' => $this->Auth->user('id')]);
        }
        
        exit;
    }
    
    
    /**
     * Edit Profile method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editProfile() {
        
        $user = $this->Users->get($this->Auth->user('id'));
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $data = $this->request->getData();
            
            if (empty($data['password'])) {
                unset($data['password']);
            }
            
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Auth->setUser($user);
                $this->Flash->success(__('Your profile has been updated.'));
                
                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
    }
    
    /**
     * Reset Password  method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function resetPassword($forgotPasswordToken) {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        
        $this->viewBuilder()->setLayout('home');
        
        $user = $this->Users->findByForgotPasswordToken($forgotPasswordToken)->first();
        if (!empty($user)) {
            $this->set('forgotPasswordToken', $forgotPasswordToken);
        } else {
            $this->Flash->error(__('Forgot password token has been expired. Please, try again.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }
    
    public function resetPasswordApi() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->findByForgotPasswordToken($this->request->data['forgot_password_token'])->first();
            if ($user) {
                /*
                 * Restrict user to edit only while listed fields
                 */
                $editableFields = ['password', 'verify_password', 'forgot_password_token'];
                foreach ($this->request->data as $field => $val) {
                    if (!in_array($field, $editableFields)) {
                        unset($this->request->data[$field]);
                    }
                }
                $user['forgot_password_token'] = "";
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->responseMessage = __('Your password has been updated.');
                    $this->responseCode = SUCCESS_CODE;
                } else {
                    $this->responseMessage = __('Something went wrong. Please, try again.');
                }
            } else {
                $this->responseMessage = __('Forgot password token has been expired. Please, try again.');
            }
        }
        echo $this->responseFormat();
    }
    
    /**
     * Reset Password  method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function forgotPassword() {
        if ($this->Auth->user()) {
            return $this->redirect($this->Auth->redirectUrl());
        }
        $this->viewBuilder()->setLayout('home');
    }
    
    
    public function forgotPasswordApi() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->findByEmail($this->request->data['email'])->first();
            
            if (!empty($user)) {
                $user->forgot_password_token = md5(uniqid(rand(), true));
                //$resetUrl = $this->request->scheme() . '://' . $this->request->host() . '/users/reset-password/' . $user->forgot_password_token;
                $resetUrl = SITE_URL . '/users/reset-password/' . $user->forgot_password_token;
                if ($this->Users->save($user)) {
                    $options = ['template' => 'forgot_password', 'to' => $this->request->data['email'], 'subject' => _('Reset Password'), 'viewVars' => ['name' => $user->first_name, 'resetUrl' => $resetUrl,]];
                    
                    $this->loadComponent('EmailManager');
                    $this->EmailManager->sendEmail($options);
                    $this->responseCode = SUCCESS_CODE;
                    $this->responseMessage = __('A link to reset the password with the instruction has been sent to your inbox');
                }
            } else {
                $this->responseCode = EMAIL_DOESNOT_REGISTERED;
                $this->responseMessage = __('Email does not exists');
            }
        }
        
        echo $this->responseFormat();
    }
    
    /**
     * View Profile method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function profile() {
        
        $user = $this->Users->get($this->Auth->user('id'));
        
        unset($user->password);
        
        $usaStates = $this->usaStates();
        $this->set('usaStates', $usaStates);
        
        $this->set(compact('user', 'token', 'id'));
        $this->set('_serialize', ['user', 'token']);
        
        if ($user->role == "Private Citizen") {
            $userDetails = TableRegistry::get('UserDetails');
            $userId = $this->Auth->user('id');
            $userDetail = $userDetails->find('all', ['conditions' => ['user_id' => $userId]])->first();
            
            if (empty($userDetail)) {
                $userDetail = [];
            }
            
            
            $howActiveAreYouInPoliticsOptions = ['Watch the News', 'Attend rallies', 'Write to local leaders', 'Active on Social Media', 'All the above', 'None of the above'];
            
            
            $this->set('userDetail', $userDetail);
            $this->set('howActiveAreYouInPoliticsOptions', $howActiveAreYouInPoliticsOptions);
            $this->render('private_citizen_profile');
        } else {
            $this->render('politician_profile');
        }
    }
    
    public function isUniqueEmail($id = null) {
        $this->autoRender = false;
        if ($id === null) {
            if ($this->Users->findByEmail($this->request->query['email'])->count()) {
                $alreadyExists = "false";
            } else {
                $alreadyExists = "true";
            }
        } else {
            $count = $this->Users->find()
                ->where(['id !=' => $id, 'email' => $this->request->query['email']])
                ->count();
            if ($count) {
                $alreadyExists = "false";
            } else {
                $alreadyExists = "true";
            }
        }
        echo $alreadyExists;
        exit;
    }
    
    public function changeProfileImage() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->findById($this->Auth->user('id'))->first();
            if ($user) {
                /*
                 * Restrict user to edit only while listed fields
                 */
                $editableFields = ['profile_image'];
                foreach ($this->request->data as $field => $val) {
                    if (!in_array($field, $editableFields)) {
                        unset($this->request->data[$field]);
                    }
                }
                $user = $this->Users->patchEntity($user, $this->request->getData());
                if ($this->Users->save($user)) {
                    $this->Auth->setUser($user);
                    $this->responseMessage = __('Profile image has been saved.');
                    $this->responseCode = SUCCESS_CODE;
                } else {
                    $this->getErrorMessage($user->errors());
                }
            } else {
                $this->responseCode = RECORD_NOT_FOUND;
                $this->responseMessage = __('User not found.');
            }
        }
        echo $this->responseFormat();
    }
    
    public function settings() {
        //Do something
    }
    
    
    public function privateCitizen() {
        //Do Something
        
        $userDetails = TableRegistry::get('UserDetails');
        $userId = $this->Auth->user('id');
        $userDetail = $userDetails->find('all', ['conditions' => ['user_id' => $userId]])->first();
        
        if (empty($userDetail)) {
            $userDetail = [];
        }
        
        $howActiveAreYouInPoliticsOptions = ['Watch the News', 'Attend rallies', 'Write to local leaders', 'Active on Social Media', 'All the above', 'None of the above'];
        
        
        $this->set('howActiveAreYouInPoliticsOptions', $howActiveAreYouInPoliticsOptions);
        $this->set('userDetail', $userDetail);
    }
    
    public function privateCitizenApi($userId = null, $type = null) {
        $this->autoRender = false;
        $user = $this->Users->findById($userId)->first();
        if ($user) {
            $user->user_type = $type;
            $user->registration_steps_done = true;
            if ($this->Users->save($user)) {
                $subscriptions = TableRegistry::get('Subscriptions');
                $subscription = $subscriptions->newEntity();
                $subscription->user_id = $userId;
                $subscription->role = 'Private Citizen';
                $subscription->user_type = $type;
                $subscription->price = ($type == "Citizen") ? '0.99' : '4.99';
                
                $subscriptions->save($subscription);
                
                $this->Flash->success(__('Thank you for subscription.'));
                return $this->redirect(['action' => 'dashboard']);
            } else {
                $this->Flash->success(__('Something went wrong, please try again.'));
                return $this->redirect(['action' => 'privateCitizen']);
            }
        }
    }
    
    public function politician() {
        //Do Something
        $authUser = $this->Auth->user();
        $daysOld = $this->dateDiff($authUser['created']);
        
        $this->set('daysOld', $daysOld);
    }
    
    public function politicianApi($userId = null) {
        $this->autoRender = false;
        
        $user = $this->Users->findById($userId)->first();
        if ($user) {
            $user->registration_steps_done = true;
            $user->user_type = "Politician";
            if ($this->Users->save($user)) {
                $subscriptions = TableRegistry::get('Subscriptions');
                $subscription = $subscriptions->newEntity();
                $subscription->user_id = $userId;
                $subscription->role = 'Politician';
                $subscription->user_type = 'Politician';
                $subscription->price = '49.99';
                
                $subscriptions->save($subscription);
                $this->Flash->success(__('Thank you for subscription.'));
                return $this->redirect(['controller' => 'Articles', 'action' => 'platform']);
            } else {
                $this->Flash->success(__('Something went wrong, please try again.'));
                return $this->redirect(['action' => 'politician']);
            }
        }
    }
    
    
    public function saveDetails() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is('post')) {
            $userDetails = TableRegistry::get('UserDetails');
            $userId = $this->Auth->user('id');
            $userDetail = $userDetails->find('all', ['conditions' => ['user_id' => $userId]])->first();
            if (empty($userDetail)) {
                $userDetail = $userDetails->newEntity();
            }
            
            $howActiveAreYouInPoliticsOptions = ['Watch the News', 'Attend rallies', 'Write to local leaders', 'Active on Social Media', 'All the above', 'None of the above'];
            
            $data = $this->request->getData();
            
            $dataKeys = array_keys($data);
            
            foreach ($howActiveAreYouInPoliticsOptions as $op) {
                $key = str_replace(" ", "_", strtolower($op));
                if (!in_array($key, $dataKeys)) {
                    $data[$key] = false;
                }
            }
            
            $userDetail = $userDetails->patchEntity($userDetail, $data);
            
            $userDetail->user_id = $userId;
            
            if ($userDetails->save($userDetail)) {
                $this->responseCode = SUCCESS_CODE;
                $this->responseMessage = __('Your details has been successfully saved');
                $this->Flash->success(__('Your details has been successfully saved'));
            } else {
                if (is_array($userDetail->errors())) {
                    foreach ($userDetail->errors() as $errors) {
                        foreach ($errors as $err) {
                            $this->responseMessage = $err;
                        }
                    }
                }
            }
        }
        
        echo $this->responseFormat();
    }
    
    public function nonGovernmentalEmailApi() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is('post')) {
            $user = $this->Users->findById($this->Auth->user('id'))->first();
            if ($user) {
                $user->non_governmental_email = $this->request->data['non_governmental_email'];
                if ($this->Users->save($user)) {
                    $this->Auth->setUser($user);
                    $this->responseCode = SUCCESS_CODE;
                    $this->responseMessage = __('Your non-governmental email has been successfully saved');
                } else {
                    $this->responseMessage = __('Something went wrong, please try again.');
                }
            }
        }
        echo $this->responseFormat();
    }
    
    public function phoneNumberApi() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        if ($this->request->is('post')) {
            $user = $this->Users->findById($this->Auth->user('id'))->first();
            if ($user) {
                $user->phone_number = $this->request->data['phone_number'];
                if ($this->Users->save($user)) {
                    $this->Auth->setUser($user);
                    $this->responseCode = SUCCESS_CODE;
                    $this->responseMessage = __('Your phone number has been successfully saved');
                } else {
                    $this->responseMessage = __('Something went wrong, please try again.');
                }
            }
        }
        echo $this->responseFormat();
    }
    
    public function markStepCrossed() {
        $this->autoRender = false;
        $this->responseCode = CODE_BAD_REQUEST;
        $user = $this->Users->findById($this->Auth->user('id'))->first();
        if ($user) {
            $user->step_crossed = true;
            if ($this->Users->save($user)) {
                $this->responseCode = SUCCESS_CODE;
                $this->responseMessage = __('Step Crossed Marked');
            }
        }
        
        echo $this->responseFormat();
    }
}
