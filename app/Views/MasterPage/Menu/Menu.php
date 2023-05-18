<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= base_url(); ?>/public/images/user.png" style="widht:30px; height:30px" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?php echo session()->get('nombre'); ?></p>
            <p class="app-sidebar__user-designation" style="font-size:11px;"><?php echo session()->get('puesto'); ?></p>
        </div>
    </div>

    <ul class="app-menu">

        <!-- MENÚS -->

        <!-- CATÁLOGOS GENERALES-->

        <?php if(session()->get('id_perfil') == 1 || session()->get('id_perfil') == 2 ){?></p>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon far fa-list-alt"></i>
                <span class="app-menu__label">Catálogos Generales</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>actividadeconomica">
                        <i class="fas fa-store-alt"></i>&nbsp;&nbsp;&nbsp;Act. Económica
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>regimenfiscal">
                        <i class="fa fa-book"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Régimen Fiscal
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>socio">
                        <i class="fas fa-handshake"></i>&nbsp;&nbsp;&nbsp;Socio
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>tiporesponsable">
                        <i class="fas fa-tags"></i>&nbsp;&nbsp;&nbsp;Tipo Responsable
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>responsable">
                        <i class="fas fa-user-tag"></i>&nbsp;&nbsp;&nbsp;&nbsp;Responsable
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>notaria">
                        <i class="fas fa-hotel"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Notaria Pública
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>tipocliente">
                        <i class="fas fa-building"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tipo Cliente
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>pais">
                        <i class="fas fa-flag"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;País
                    </a> 
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>entidadFed">
                        <i class="fas fa-map"></i>&nbsp;&nbsp;&nbsp;&nbsp;Estado
                    </a> 
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>alcaldiaMunicipio">
                        <i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ciudad
                    </a> 
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>catTipoCasoLegal">
                        <i class="fas fa-vote-yea"></i>&nbsp;&nbsp;&nbsp;Tipo Caso Legal
                    </a> 
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>catEstadoCasoLegal">
                        <i class="fas fa-swatchbook"></i>&nbsp;&nbsp;&nbsp;&nbsp;Seguimiento Caso Legal
                    </a> 
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>catJuzgado">
                        <i class="fas fa-landmark"></i>&nbsp;&nbsp;&nbsp;&nbsp;Juzgado
                    </a>
                </li>
            </ul>
        </li>

        <?php }  ?></p>
        <!-- FIN CATÁLOGOS GENERALES-->
        
        <!-- CATÁLOGOS NEGOCIO-->

        <?php if(session()->get('id_perfil') == 1 || session()->get('id_perfil') == 2 ){?></p>

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fas fa-hand-holding-usd"></i>
                <span class="app-menu__label">Catálogos Negocio</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>capturacliente">
                        <i class="fas fa-address-book"></i>&nbsp;&nbsp;&nbsp;&nbsp;Cliente (Alta-Modif.)
                    </a> 
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>CarteraClientes">
                        <i class="fa fa-briefcase"></i>&nbsp;&nbsp;&nbsp;&nbsp;Cartera de Clientes
                    </a> 
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>relClienteSocio">
                        <i class="fas fa-user-tie"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cliente - Socio
                    </a> 
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>relClienteTResponsable">
                        <i class="fas fa-id-badge"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cliente - Responsable
                    </a> 
                </li>
            </ul>
        </li>

        <?php }  ?></p>
        <!-- FIN CATÁLOGOS NEGOCIO-->

        <!-- CASO LEGAL-->

        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fas fa-balance-scale"></i>
                <span class="app-menu__label">&nbsp;Caso legal</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <?php if(session()->get('id_perfil') == 1 || session()->get('id_perfil') == 2 ){?></p>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>CasoLegal">
                        <i class="fas fa-gavel">&nbsp;&nbsp;&nbsp;</i> Caso Legal
                    </a>
                </li>
                <?php }  ?></p>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>Expedientes">
                        <i class="fas fa-folder">&nbsp;&nbsp;&nbsp;</i> Expedientes
                    </a>
                </li>
            </ul>
           
        </li>
        <!-- FIN CASO LEGAL-->

        <!-- ADMINISTRACION DE USUARIOS -->
        
        <?php if(session()->get('id_perfil') == 1){?></p>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label">&nbsp;Administrar usuarios</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>usuarios">
                        <i class="fas fa-user-cog">&nbsp;&nbsp;&nbsp;&nbsp;</i> Usuarios del Sistema
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>sistClienteUsuarioInt">
                        <i class="fa fa-user">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i> Cliente - Usuarios Int.
                    </a>
                </li>
                <li>
                    <a class="treeview-item" href="<?= base_url(); ?>sistClienteUsuarioExt">
                        <i class="fas fa-user-secret">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i> Cliente - Usuarios Ext.
                    </a>
                </li>
            </ul>
        </li>
        <?php }  ?></p>
        <!-- FIN DE ADMINISTRACION DE USUARIOS -->

        <!-- SALIDA-->
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>logout">
                <i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">&nbsp;Salir</span>
            </a>
        </li>
        <!-- FIN SALIDA-->

    </ul>
</aside>