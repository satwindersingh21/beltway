<header>
    <div class="col-md-5">
        <div class="logo">
            <a href="<?= SITE_URL ?>" title="index">
                <?= $this->Html->image('logo.png', ['alt' =>SITE_TITLE]);  ?>
            </a>
        </div>
    </div>
    <div class="col-md-7">
        <nav id="top-nav">
            <ul>
                <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'contactUs']); ?>">Contact us</a></li>
                <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'aboutUs']); ?>">About</a></li>
    
                <?php if($this->request->params['action'] == 'register') {  ?>
                    <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']); ?>">Login</a></li>
                <?php } else { ?>
                    <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']); ?>">Register</a></li>
                <?php } ?>
                
            </ul>
        </nav>
    </div>
</header>
