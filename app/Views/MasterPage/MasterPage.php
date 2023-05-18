<!DOCTYPE html>

<html lang="es">

<head>
    <title>LECO</title>
    <meta charset="utf-8">
    <meta name="description" content="Expedientes">
    <!-- Twitter meta-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= base_url(); ?>public/images/icono.png">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/css/select2.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/css/DataTables/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/css/DataTables/css/responsive.dataTables.css">
    
    <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>public/css/dynamics.css" rel="stylesheet" />
    <!--<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>Assets/css/bootstrap-treeview.min.css"/>-->
    <!--<link rel="stylesheet" href="<?= base_url(); ?>Assets/trumbowyg/dist/ui/trumbowyg.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>Assets/trumbowyg/dist/plugins/table/ui/trumbowyg.table.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>Assets/trumbowyg/dist/plugins/colors/ui/trumbowyg.colors.min.css">-->



    <script>
        const base_url = "<?= base_url(); ?>"
    </script>

    <?= $this->renderSection('HeadContent'); ?>
</head>

<body class="app sidebar-mini">
    <header class="app-header"><a class="app-header__logo" href="<?= base_url() ?>Home" style="font-family: Lato;"> L E C O </a>
        <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
        <!-- Navbar Right Menu-->
        <ul class="app-nav">
            <!-- User Menu-->
            <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                <ul class="dropdown-menu settings-menu dropdown-menu-right">
                    <li><a class="dropdown-item" href="<?= base_url() ?>logout"><i class="fa fa-sign-out fa-lg"></i> Salir</a></li>
                </ul>
            </li>
        </ul>
    </header>

    <?= $this->include('MasterPage/Menu/Menu');?>

    <main class="app-content">
        <?= $this->renderSection('MainContent'); ?>
    </main>

    <div id="cuerpo-content"></div>

    <!--script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></!--script>-->
    <script src="<?= base_url(); ?>public/js/jquery-3.5.1.js"></script>
    <script src="<?= base_url(); ?>public/js/popper.min.js"></script>
    <script src="<?= base_url(); ?>public/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>public/js/main.js"></script>
    <script src="<?= base_url(); ?>public/js/fontawesome.js"></script>
    <!--<script src="<?= base_url(); ?>public/js/functions_admin.js"></script>-->
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= base_url(); ?>public/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="<?= base_url(); ?>public/js/plugins/sweetalert.min.js"></script>
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <!--data table plugin-->
    <script type="text/javascript" language="javascript" src="<?= base_url(); ?>public/js/plugins/select2.min.js"></script>
    <!-- <script type="text/javascript" language="javascript" src="<?= base_url(); ?>public/js/plugins/jquery.dataTables.min.js"></script> -->
    <!-- <script type="text/javascript" language="javascript" src="<?= base_url(); ?>public/js/plugins/dataTables.bootstrap.min.js"></script> -->
    <script type="text/javascript" language="javascript" src="<?= base_url(); ?>public/js/plugins/DataTables/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="<?= base_url(); ?>public/js/plugins/DataTables/dataTables.responsive.js"></script>
    <!-- <script type="text/javascript" language="javascript" src="<?= base_url(); ?>public/js/plugins/DataTables/dataTables.buttons.min.js"></script> -->
    <script type="text/javascript" language="javascript" src="<?= base_url(); ?>public/js/plugins/bootstrap-select.min.js"></script>
    <!--<script type="text/javascript" language="javascript" src="<?= base_url(); ?>Assets/js/functions_admin.js"></script>-->
    <script type="text/javascript" language="javascript" src="<?= base_url(); ?>public/js/plugins/dynamics-1.00.0.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <!--<script type="text/javascript" language="javascript" src="<?= base_url(); ?>Assets/js/plugins/bootstrap-treeview.min.js"></script>-->
    <!--<script src="<?= base_url(); ?>Assets/trumbowyg/dist/trumbowyg.min.js"></script>
    <script src="<?= base_url(); ?>Assets/trumbowyg/dist/plugins/table/trumbowyg.table.min.js"></script>
    <script src="<?= base_url(); ?>Assets/trumbowyg/dist/plugins/cleanpaste/trumbowyg.cleanpaste.min.js"></script>
    <script src="<?= base_url(); ?>Assets/trumbowyg/dist/plugins/colors/trumbowyg.colors.min.js"></script>
    <script src="<?= base_url(); ?>Assets/trumbowyg/dist/plugins/history/trumbowyg.history.min.js"></script>-->
    

<!--     <script type="text/javascript" src='https://cdn.tiny.cloud/1/w4bodboci7ga2gi83re4as0eyr4tl3rm4eocee8b2blbbj6f/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
 -->
    <?= $this->renderSection('FooterContent'); ?>

</body>

</html>