<?php

  /**
   * Password Protect Controller
   *
   * @category Controller
   * @package  Croogo
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreek.co.uk>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://www.firecreek.co.uk
   */
  class PasswordprotectController extends PasswordprotectAppController {
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Passwordprotect';
      
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array('Passwordprotect.Htaccess','Passwordprotect.Htpasswd');


    /**
     * Before filter
     *
     * @access public
     * @return void
     */
    public function beforeFilter() {
      parent::beforeFilter();

      // CSRF Protection
      if (in_array($this->params['action'], array('admin_index'))) {
        $this->Security->validatePost = false;
      }
    }
    
    
    /**
     * Before Render
     *
     * @access public
     * @return void
     */
    public function beforeRender()
    {
      parent::beforeRender();
      
      $htaccess = $this->Htaccess->file;
      $htpasswd = $this->Htpasswd->file;
      $enabled  = $this->Htaccess->enabled();
      
      $this->set(compact('htaccess','htpasswd','enabled'));
    }


    /**
     * Admin index
     *
     * List existing redirect routes
     *
     * @access public
     * @return void
     */
    public function admin_index()
    {
      $this->set('title_for_layout', __('Password Protect'));
      
      $records = $this->Htpasswd->find('all');
      
      $this->set(compact('records'));
    }


    /**
     * Admin add
     *
     * @access public
     * @return void
     */
    public function admin_add()
    {
      $this->set('title_for_layout', __('Htpasswd Add User'));
      
      if (!empty($this->data)) {
        if ($this->Htpasswd->save($this->data)) {
          $this->Session->setFlash(__('User has been added'), 'default', array('class' => 'success'));
          $this->redirect(array('action'=>'index'));
        } else {
          $this->Session->setFlash(__('User could not be saved. Please, try again.'), 'default', array('class' => 'error'));
        }
      }
    }


    /**
     * Admin edit
     *
     * @access public
     * @return void
     */
    public function admin_edit($username)
    {
      $this->set('title_for_layout', __('Htpasswd User Edit '.$username));
    
      if (!empty($this->data)) {
          $this->data['Htpasswd']['username'] = $username;
          
          if ($this->Htpasswd->save($this->data)) {
              $this->Session->setFlash(__('User password has been updated'), 'default', array('class' => 'success'));
              $this->redirect(array('action'=>'index'));
          } else {
              $this->Session->setFlash(__('User password could not be updated'), 'default', array('class' => 'error'));
          }
      }
    }


    /**
     * Admin delete
     *
     * @access public
     * @return void
     */
    public function admin_delete($username)
    {
      if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
          $blackHoleCallback = $this->Security->blackHoleCallback;
          $this->$blackHoleCallback();
      }
      if ($this->Htpasswd->delete($username)) {
        $this->Session->setFlash(__('User deleted'), 'default', array('class' => 'success'));
      }
      else
      {
        $this->Session->setFlash(__('Failed to delete user'), 'default', array('class' => 'error'));
      }
      
      $this->redirect(array('action'=>'index'));
    }


    /**
     * Admin enable
     *
     * @access public
     * @return void
     */
    public function admin_enable()
    {
      if($this->Htaccess->enable())
      {
        $this->Session->setFlash(__('Htpasswd enabled'), 'default', array('class' => 'success'));
      }
      else
      {
        $this->Session->setFlash(__('Failed to enable htpasswd'), 'default', array('class' => 'error'));
      }
      
      $this->redirect(array('action'=>'index'));
    }


    /**
     * Admin disable
     *
     * @access public
     * @return void
     */
    public function admin_disable()
    {
      if($this->Htaccess->disable())
      {
        $this->Session->setFlash(__('Htpasswd disabled'), 'default', array('class' => 'success'));
      }
      else
      {
        $this->Session->setFlash(__('Failed to disable htpasswd'), 'default', array('class' => 'error'));
      }
      
      $this->redirect(array('action'=>'index'));
    }

    

  }
?>