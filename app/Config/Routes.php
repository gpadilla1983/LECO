<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('LoginController');
$routes->setDefaultMethod('GetVista');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//ruta página principal

$routes->get('Home', 'Home::Index');


//Primera ruta para llamada a Login

$routes->get('/', 'LoginController::GetVista');

//ruta para Menu Dinámico

$routes->get('menuDinamico', 'MenuDinamicoController::GetVista');
$routes->get('menuDinamico/ObtenerMenuDinamico', 'MenuDinamicoController::ObtenerMenuDinamico');

//ruta para catálogo de Usuarios
$routes->get('usuarios', 'UsuariosController::GetVista');
$routes->post('usuarios/ObtenerUsuarios', 'UsuariosController::ObtenerUsuarios');
$routes->get('ModalUsuarios/(:num)', 'UsuariosController::ModalAgregarActualizar/$1');
$routes->post('usuarios/AgregarActualizarUsuario/(:num)', 'UsuariosController::AgregarActualizarUsuario/$1');
$routes->get('usuarios/getUsuario/(:num)', 'UsuariosController::getUsuario/$1');

//rutas para login y para cerrar la sesión
$routes->post('LoginController/authenticate', 'LoginController::authenticate/$1');
$routes->get('logout', 'LoginController::logout');

//ruta para catálogo de Registro Fiscal
$routes->get('regimenfiscal', 'RegimenFiscalController::GetVista');
$routes->post('regimenfiscal/ObtenerRegimenFiscal', 'RegimenFiscalController::ObtenerRegimenFiscal');
$routes->get('ModalRegimenFiscal/(:num)', 'RegimenFiscalController::ModalAgregarActualizar/$1');
$routes->post('regimenfiscal/AgregarActualizarRegimenFiscal/(:num)', 'RegimenFiscalController::AgregarActualizarRegimenFiscal/$1');
$routes->get('regimenfiscal/getRegimenFiscal/(:num)', 'RegimenFiscalController::getRegimenFiscal/$1');

//ruta para catálogo de Actividad Económica
$routes->get('actividadeconomica', 'ActividadEconomicaController::GetVista');
$routes->post('actividadeconomica/ObtenerActividadEconomica', 'ActividadEconomicaController::ObtenerActividadEconomica');
$routes->get('ModalActividadEconomica/(:num)', 'ActividadEconomicaController::ModalAgregarActualizar/$1');
$routes->post('actividadeconomica/AgregarActualizarActividadEconomica/(:num)', 'ActividadEconomicaController::AgregarActualizarActividadEconomica/$1');
$routes->get('actividadeconomica/getActividadEconomica/(:num)', 'ActividadEconomicaController::getActividadEconomica/$1');

//ruta para catálogo de Tipo Cliente
$routes->get('tipocliente', 'TipoClienteController::GetVista');
$routes->post('tipocliente/ObtenerTipoCliente', 'TipoClienteController::ObtenerTipoCliente');
$routes->get('ModalTipoCliente/(:num)', 'TipoClienteController::ModalAgregarActualizar/$1');
$routes->post('tipocliente/AgregarActualizarTipoCliente/(:num)', 'TipoClienteController::AgregarActualizarTipoCliente/$1');
$routes->get('tipocliente/getTipoCliente/(:num)', 'TipoClienteController::getTipoCliente/$1');

//ruta para catálogo de Tipo Responsable
$routes->get('tiporesponsable', 'TipoResponsableController::GetVista');
$routes->post('tiporesponsable/ObtenerTipoResponsable', 'TipoResponsableController::ObtenerTipoResponsable');
$routes->get('ModalTipoResponsable/(:num)', 'TipoResponsableController::ModalAgregarActualizar/$1');
$routes->post('tiporesponsable/AgregarActualizarTipoResponsable/(:num)', 'TipoResponsableController::AgregarActualizarTipoResponsable/$1');
$routes->get('tiporesponsable/getTipoResponsable/(:num)', 'TipoResponsableController::getTipoResponsable/$1');

//ruta para catálogo de Notarias Públicas
$routes->get('notaria', 'NotariaController::GetVista');
$routes->post('notaria/ObtenerNotaria', 'NotariaController::ObtenerNotaria');
$routes->get('ModalNotaria/(:num)', 'NotariaController::ModalAgregarActualizar/$1');
$routes->post('notaria/AgregarActualizarNotaria/(:num)', 'NotariaController::AgregarActualizarNotaria/$1');
$routes->get('notaria/getNotaria/(:num)', 'NotariaController::getNotaria/$1');

//ruta para catálogo de Socios
$routes->get('socio', 'SocioController::GetVista');
$routes->post('socio/ObtenerSocio', 'SocioController::ObtenerSocio');
$routes->get('ModalSocio/(:num)', 'SocioController::ModalAgregarActualizar/$1');
$routes->post('socio/AgregarActualizarSocio/(:num)', 'SocioController::AgregarActualizarSocio/$1');
$routes->get('socio/getSocio/(:num)', 'SocioController::getSocio/$1');

//ruta para catálogo de Responsable
$routes->get('responsable', 'ResponsableController::GetVista');
$routes->post('responsable/ObtenerResponsable', 'ResponsableController::ObtenerResponsable');
$routes->get('ModalResponsable/(:num)', 'ResponsableController::ModalAgregarActualizar/$1');
$routes->post('responsable/AgregarActualizarResponsable/(:num)', 'ResponsableController::AgregarActualizarResponsable/$1');
$routes->get('responsable/getResponsable/(:num)', 'ResponsableController::getResponsable/$1');

//ruta para catálogo de pais
$routes->get('pais', 'PaisController::GetVista');
$routes->post('pais/ObtenerPais', 'PaisController::ObtenerPais');
$routes->get('ModalPais/(:num)', 'PaisController::ModalAgregarActualizar/$1');
$routes->post('pais/AgregarActualizarPais/(:num)', 'PaisController::AgregarActualizarPais/$1');
$routes->get('pais/getPais/(:num)', 'PaisController::getPais/$1');

//ruta para catálogo de entidad federativa
$routes->get('entidadFed', 'EntidadFederativaController::GetVista');
$routes->post('entidadFed/ObtenerEntidadFed', 'EntidadFederativaController::ObtenerEntidadFed');
$routes->get('ModalEntidadFederativa/(:num)', 'EntidadFederativaController::ModalAgregarActualizar/$1');
$routes->post('entidadFed/AgregarActualizarEntidadFed/(:num)', 'EntidadFederativaController::AgregarActualizarEntidadFed/$1');
$routes->get('entidadFed/getEntidadFed/(:num)', 'EntidadFederativaController::getEntidadFed/$1');

//ruta para catálogo de alcaldia - municipio
$routes->get('alcaldiaMunicipio', 'AlcaldiaMunicipioController::GetVista');
$routes->post('alcaldiaMunicipio/ObtenerAlcaldiaMun', 'AlcaldiaMunicipioController::ObtenerAlcaldiaMun');
$routes->get('ModalAlcaldiaMunicipio/(:num)', 'AlcaldiaMunicipioController::ModalAgregarActualizar/$1');
$routes->post('alcaldiaMunicipio/AgregarActualizarAlcaldiaMun/(:num)', 'AlcaldiaMunicipioController::AgregarActualizarAlcaldiaMun/$1');
$routes->get('alcaldiaMunicipio/getAlcaldiaMun/(:num)', 'AlcaldiaMunicipioController::getAlcaldiaMun/$1');

//ruta para catálogo de obligacion fiscal
$routes->get('obligacionFiscal', 'ObligacionFiscalController::GetVista');
$routes->post('obligacionFiscal/ObtenerObligacionFisc', 'ObligacionFiscalController::ObtenerObligacionFisc');
$routes->get('ModalObligacionFiscal/(:num)', 'ObligacionFiscalController::ModalAgregarActualizar/$1');
$routes->post('obligacionFiscal/AgregarActualizarObligacionFisc/(:num)', 'ObligacionFiscalController::AgregarActualizarObligacionFisc/$1');
$routes->get('obligacionFiscal/getObligacionFisc/(:num)', 'ObligacionFiscalController::getObligacionFisc/$1');

//rutas para la captura de clientes

$routes->get('capturacliente', 'CapturaClientesController::GetVista');


//Ruta para carga de catalogos

$routes->get('catalogos/ObtenerMunicipios/(:num)', 'catalogosController::getCatalogoMunicipios/$1');
$routes->get('catalogos/ObtenerEntidad/(:num)', 'catalogosController::getCatalogosEntidad/$1');

//Rutas para guardar Datos Generales del Clientes
$routes->post('clientes/AgregarActualizarDatosGenerales', 'CapturaClientesController::AgregarActualizarDatosGenerales');

//Rutas para guardar Domicilio del Clientes
$routes->post('clientes/ActualizarDomicilio', 'CapturaClientesController::ActualizarDomicilio');


//ruta para buscar RFC de Socio
$routes->get('clientes/BuscarRFC/(:any)', 'CapturaClientesController::getBuscarRFC/$1');

//Agregar Socios
$routes->post('Clientes/AgregarSocio', 'CapturaClientesController::AgregarSocio');
$routes->get('Clientes/ObtenerUsuarios', 'CapturaClientesController::ObtenerUsuarios');
$routes->get('Clientes/ObtenerUsuariosbysocio', 'CapturaClientesController::ObtenerUsuariosbysocio');


//ruta para buscar RFC de Responsable
$routes->get('clientes/BuscarRFCResponsable/(:any)', 'CapturaClientesController::getBuscarRFCResponsable/$1');

//Agregar Responsable
$routes->post('Clientes/AgregarResponsable', 'CapturaClientesController::AgregarResponsable');
$routes->get('Clientes/ObtenerResponsable', 'CapturaClientesController::ObtenerResponsable');
$routes->get('Clientes/ObtenerClientebyResponsable', 'CapturaClientesController::ObtenerClientebyResponsable');


//Agregar Actualizar Actividades Económica por Cliente

$routes->post('clientes/ActualizaActividadEconomica', 'CapturaClientesController::ActualizaActividadEconomica');
$routes->get('Clientes/obtenerActividades', 'CapturaClientesController::obtenerActividades');


//Agregar Actualizar Regimen Fiscal
$routes->post('clientes/ActualizaRegimenFiscal', 'CapturaClientesController::ActualizaRegimenFiscal');
$routes->get('clientes/ObtenerRegimenFiscal', 'CapturaClientesController::ObtenerRegimenFiscal');

//Validar RFC
$routes->post('clientes/ValidarRFC', 'CapturaClientesController::ValidarRFC');

//validar CURP
$routes->post('clientes/ValidarCURP', 'CapturaClientesController::ValidarCURP');

//Obtener Clientes Registrados
$routes->get('clientes/GetClientebyRFC', 'CapturaClientesController::GetClientebyRFC');
$routes->get('clientes/GetClientebyIdCliente', 'CapturaClientesController::GetClientebyIdCliente');

//Actuzalización de datos del cliente

$routes->post('clientes/ActualizarDatosGenerales', 'CapturaClientesController::ActualizarDatosGenerales');

//ruta para catálogo de Relación Cliente - Socio
$routes->get('relClienteSocio', 'ClienteSocioController::GetVista');
$routes->post('relClienteSocio/ObtenerClienteSocio', 'ClienteSocioController::ObtenerClienteSocio');
$routes->get('ModalClienteSocio/(:num)', 'ClienteSocioController::ModalAgregarActualizar/$1');
$routes->post('relClienteSocio/AgregarActualizarClienteSocio/(:num)', 'ClienteSocioController::AgregarActualizarClienteSocio/$1');
$routes->get('relClienteSocio/getClienteSocio/(:num)', 'ClienteSocioController::getClienteSocio/$1');


//ruta para catálogo de Relación Cliente - TResponsable
$routes->get('relClienteTResponsable', 'ClienteTResponsableController::GetVista');
$routes->post('relClienteTResponsable/ObtenerClienteTResponsable', 'ClienteTResponsableController::ObtenerClienteTResponsable');
$routes->get('ModalClienteTResponsable/(:num)', 'ClienteTResponsableController::ModalAgregarActualizar/$1');
$routes->post('relClienteTResponsable/AgregarActualizarClienteTResponsable/(:num)', 'ClienteTResponsableController::AgregarActualizarClienteTResponsable/$1');
$routes->get('relClienteTResponsable/getClienteTResponsable/(:num)', 'ClienteTResponsableController::getClienteTResponsable/$1');

//ruta para catálogo de Relación Cliente - Régimen Fiscal
$routes->get('relClienteRegimenFiscal', 'ClienteRegimenFiscalController::GetVista');
$routes->post('relClienteRegimenFiscal/ObtenerClienteRegimenFiscal', 'ClienteRegimenFiscalController::ObtenerClienteRegimenFiscal');
$routes->get('ModalClienteRegimenFiscal/(:num)', 'ClienteRegimenFiscalController::ModalAgregarActualizar/$1');
$routes->post('relClienteRegimenFiscal/AgregarActualizarClienteRegimenFiscal/(:num)', 'ClienteRegimenFiscalController::AgregarActualizarClienteRegimenFiscal/$1');
$routes->get('relClienteRegimenFiscal/getClienteRegimenFiscal/(:num)', 'ClienteRegimenFiscalController::getClienteRegimenFiscal/$1');

//ruta para catálogo de Relación Cliente - Actividad Economica
$routes->get('relClienteActividadEconomica', 'ClienteActividadEconomicaController::GetVista');
$routes->post('relClienteActividadEconomica/ObtenerClienteActividadEconomica', 'ClienteActividadEconomicaController::ObtenerClienteActividadEconomica');
$routes->get('ModalClienteActividadEconomica/(:num)', 'ClienteActividadEconomicaController::ModalAgregarActualizar/$1');
$routes->post('relClienteActividadEconomica/AgregarActualizarClienteActividadEconomica/(:num)', 'ClienteActividadEconomicaController::AgregarActualizarClienteActividadEconomica/$1');
$routes->get('relClienteActividadEconomica/getClienteActividadEconomica/(:num)', 'ClienteActividadEconomicaController::getClienteActividadEconomica/$1');





//rutas para la Expedientes

$routes->get('FilesCliente', 'FilesClienteController::GetVista');
$routes->post('FilesCliente/GuardarExpediente', 'FilesClienteController::GuardarExpediente');
$routes->post('FilesCliente/ActualizarExpedienteSinArchivo', 'FilesClienteController::ActualizarExpedienteSinArchivo');
$routes->post('FilesClientes/ObtenerExpedientes', 'FilesClienteController::ObtenerExpedientes');
$routes->post('FilesClientes/ObtenerExpedientesExternos', 'FilesClienteController::ObtenerExpedientesExternos');
$routes->get('FilesClientes/ObtenerFileContent/(:num)', 'FilesClienteController::ObtenerFileContent/$1');
$routes->post('FilesCliente/EliminarArchivo', 'FilesClienteController::EliminarArchivo');
$routes->post('FilesCliente/ActivarArchivo', 'FilesClienteController::ActivarArchivo');
$routes->get('FilesClientes/ObtenerDocumento/(:num)', 'FilesClienteController::ObtenerDocumento/$1');

//ruta para catálogo de Tipo Caso Legal
$routes->get('catTipoCasoLegal', 'TipoCasoLegalController::GetVista');
$routes->post('catTipoCasoLegal/ObtenerTipoCasoLegal', 'TipoCasoLegalController::ObtenerTipoCasoLegal');
$routes->get('ModalTipoCasoLegal/(:num)', 'TipoCasoLegalController::ModalAgregarActualizar/$1');
$routes->post('catTipoCasoLegal/AgregarActualizarTipoCasoLegal/(:num)', 'TipoCasoLegalController::AgregarActualizarTipoCasoLegal/$1');
$routes->get('catTipoCasoLegal/getTipoCasoLegal/(:num)', 'TipoCasoLegalController::getTipoCasoLegal/$1');

//ruta para catálogo de Estado Caso Legal
$routes->get('catEstadoCasoLegal', 'EstadoCasoLegalController::GetVista');
$routes->post('catEstadoCasoLegal/ObtenerEstadoCasoLegal', 'EstadoCasoLegalController::ObtenerEstadoCasoLegal');
$routes->get('ModalEstadoCasoLegal/(:num)', 'EstadoCasoLegalController::ModalAgregarActualizar/$1');
$routes->post('catEstadoCasoLegal/AgregarActualizarEstadoCasoLegal/(:num)', 'EstadoCasoLegalController::AgregarActualizarEstadoCasoLegal/$1');
$routes->get('catEstadoCasoLegal/getEstadoCasoLegal/(:num)', 'EstadoCasoLegalController::getEstadoCasoLegal/$1');


//ruta para catálogo de Juzgado
$routes->get('catJuzgado', 'JuzgadoController::GetVista');
$routes->post('catJuzgado/ObtenerJuzgado', 'JuzgadoController::ObtenerJuzgado');
$routes->get('ModalJuzgado/(:num)', 'JuzgadoController::ModalAgregarActualizar/$1');
$routes->post('catJuzgado/AgregarActualizarJuzgado/(:num)', 'JuzgadoController::AgregarActualizarJuzgado/$1');
$routes->get('catJuzgado/getJuzgado/(:num)', 'JuzgadoController::getJuzgado/$1');

//ruta para Cartera de Clientes 
$routes->get('CarteraClientes', 'CarteraClientesController::GetVista');
$routes->post('CarteraClientes/ObtenerCarteraCliente', 'CarteraClientesController::ObtenerCarteraCliente');
$routes->post('CarteraClientes/ActivarCliente/(:num)', 'CarteraClientesController::ActivarCliente/$1');
$routes->post('CarteraClientes/DesactivarCliente/(:num)', 'CarteraClientesController::DesactivarCliente/$1');

//ruta para catálogo de Cliente - Usuario Interno
$routes->get('sistClienteUsuarioInt', 'UsuarioIntClienteController::GetVista');
$routes->post('sistClienteUsuarioInt/ObtenerClienteUsuarioInt', 'UsuarioIntClienteController::ObtenerClienteUsuarioInt');
$routes->post('sistClienteUsuarioInt/ObtenerClienteSinUsuarioInt', 'UsuarioIntClienteController::ObtenerClienteSinUsuarioInt');
$routes->get('ModalClienteUsuarioInt/(:num)', 'UsuarioIntClienteController::ModalAgregarActualizar/$1');
$routes->post('sistClienteUsuarioInt/AgregarActualizarClienteUsuarioInt/(:num)', 'UsuarioIntClienteController::AgregarActualizarClienteUsuarioInt/$1');
$routes->get('sistClienteUsuarioInt/getClienteUsuarioInt/(:num)', 'UsuarioIntClienteController::getClienteUsuarioInt/$1');



//ruta para catálogo de Cliente - Usuario Externo
$routes->get('sistClienteUsuarioExt', 'UsuarioExtClienteController::GetVista');
$routes->post('sistClienteUsuarioExt/ObtenerClienteUsuarioExt', 'UsuarioExtClienteController::ObtenerClienteUsuarioExt');
$routes->get('ModalClienteUsuarioExt/(:num)', 'UsuarioExtClienteController::ModalAgregarActualizar/$1');
$routes->post('sistClienteUsuarioExt/AgregarActualizarClienteUsuarioExt/(:num)', 'UsuarioExtClienteController::AgregarActualizarClienteUsuarioExt/$1');
$routes->get('sistClienteUsuarioExt/getClienteUsuarioExt/(:num)', 'UsuarioExtClienteController::getClienteUsuarioExt/$1');


//rutas para Casos Legales
$routes->get('CasoLegal', 'ClienteCasoLegalController::GetVista');
$routes->post('CasoLegal/AgregarActualizarDatosGenerales', 'ClienteCasoLegalController::AgregarActualizarDatosGenerales');
$routes->post('CasoLegal/ObtenerCasoLegal', 'ClienteCasoLegalController::ObtenerCasoLegal');
$routes->get('CasoLegal/getClienteCasoLegal/(:num)', 'ClienteCasoLegalController::getClienteCasoLegal/$1');

//rutas para Expedientes
$routes->get('Expedientes', 'ExpedientesController::GetVista');
$routes->post('Expedientes/ObtenerCasoLegal', 'ExpedientesController::ObtenerCasoLegal');
$routes->get('Expedientes/getClienteCasoLegal/(:num)', 'ExpedientesController::getClienteCasoLegal/$1');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
