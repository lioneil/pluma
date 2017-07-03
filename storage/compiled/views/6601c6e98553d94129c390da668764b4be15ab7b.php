<aside class="mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
    <header class="XXXX-drawer-header">
        <img src="images/user.jpg" class="XXXX-avatar">
        <div class="XXXX-avatar-dropdown">
            <span>hello@example.com</span>
            <div class="mdl-layout-spacer"></div>
            <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
            <i class="material-icons" role="presentation">arrow_drop_down</i>
            <span class="visuallyhidden">Accounts</span>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="accbtn">
                <li class="mdl-menu__item">hello@example.com</li>
                <li class="mdl-menu__item">info@example.com</li>
                <li class="mdl-menu__item"><i class="material-icons">add</i>Add another account...</li>
            </ul>
        </div>
    </header>
    <span class="mdl-layout-title"><?php echo e($application->site->title); ?></span>

    
    <?php echo $__env->make("Frontier::templates.navigations.sidebar", ['menus' => collect($navigation->sidebar->collect)], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</aside>
