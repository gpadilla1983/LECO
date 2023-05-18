<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= base_url(); ?>/public/images/user.png" style="widht:30px; height:30px" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?php echo session()->get('nombre'); ?></p>
            <p class="app-sidebar__user-designation" style="font-size:11px;"><?php echo session()->get('puesto'); ?></p>
        </div>
    </div>

    <ul class="app-menu">
        <?php foreach ($MenuDinamico as $EF) { ?>
                            
                                <?php echo $EF->ruta ?>
                            
                        <?php } ?>
            
    </ul>
</aside>
