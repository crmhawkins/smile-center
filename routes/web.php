<?php

use App\Http\Controllers\CajaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BudgetReferenceAutopincrementsController;
use App\Http\Controllers\BudgetStatuController;
use App\Http\Controllers\ClientsEmailController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\ProjectPriorityController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ArticulosController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\AseguradoraController;
use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\IvaController;
use App\Http\Controllers\ProductosCategoriesController;
use App\Http\Controllers\DepartamentosUserController;
use App\Http\Controllers\TipoGastoController;
use App\Http\Controllers\CategoriaEventoController;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\DisponiblesController;


use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ServicioCategoriaController;
use App\Http\Controllers\ServicioPackController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ResumenDiaController;
use App\Http\Controllers\ResumenSemanaController;
use App\Http\Controllers\ResumenMensualController;
use App\Http\Controllers\ContratoController;
use App\Http\Controllers\MapKitController;
use App\Http\Livewire\Facturas\EditComponent;
use App\Http\Livewire\Facturas\IndexComponent as FacturasIndexComponent;
use App\Http\Livewire\Productos\IndexComponent;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\NewslettersController;
use App\Http\Controllers\StatisticsController;
use UniSharp\LaravelFilemanager\Lfm;


use App\Http\Middleware\IsAdmin;
use FontLib\Table\Type\name;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::name('inicio')->get('/', function () {
    return view('auth.login');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');



Route::group(['middleware' => 'is.admin', 'prefix' => 'admin'], function () {

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        Lfm::routes();
    });
    /* --------------------------------------- */
    // Budgets
    Route::get('budgets', [BudgetController::class, 'index'])->name('budget.index');
    Route::get('budget-create', [BudgetController::class, 'create'])->name('budget.create');
    Route::post('budget-store', [BudgetController::class, 'store'])->name('budget.store');
    Route::get('budget-edit', [BudgetController::class, 'edit'])->name('budget.edit');
    Route::post('budget-update', [BudgetController::class, 'update'])->name('budget.update');
    Route::delete('budget-delete', [BudgetController::class, 'delete'])->name('budget.delete');

    // Budgets Reference Autoincremental
    Route::get('budgets-reference', [BudgetReferenceAutopincrementsController::class, 'index'])->name('budgetReference.index');
    Route::get('budget-reference-create', [BudgetReferenceAutopincrementsController::class, 'create'])->name('budgetReference.create');
    Route::post('budget-reference-store', [BudgetReferenceAutopincrementsController::class, 'store'])->name('budgetReference.store');
    Route::get('budget-reference-edit', [BudgetReferenceAutopincrementsController::class, 'edit'])->name('budgetReference.edit');
    Route::post('budget-reference-update', [BudgetReferenceAutopincrementsController::class, 'update'])->name('budgetReference.update');
    Route::delete('budget-reference-delete', [BudgetReferenceAutopincrementsController::class, 'delete'])->name('budgetReference.delete');

    // Budgets Status
    Route::get('budgets-status', [BudgetStatuController::class, 'index'])->name('budgetStatus.index');
    Route::get('budget-status-create', [BudgetStatuController::class, 'create'])->name('budgetStatus.create');
    Route::post('budget-status-store', [BudgetStatuController::class, 'store'])->name('budgetStatus.store');
    Route::get('budget-status-edit', [BudgetStatuController::class, 'edit'])->name('budgetStatus.edit');
    Route::post('budget-status-update', [BudgetStatuController::class, 'update'])->name('budgetStatus.update');
    Route::delete('budget-status-delete', [BudgetStatuController::class, 'delete'])->name('budgetStatus.delete');

    /* --------------------------------------- */

    // RECORDATORIO: IMPORTAR CONTROLADORES NUEVOS
    // Alumnos
    Route::get('alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');
    Route::get('alumnos-create', [AlumnoController::class, 'create'])->name('alumnos.create');
    Route::get('alumnos-edit/{id}', [AlumnoController::class, 'edit'])->name('alumnos.edit');

    // Calendario
    Route::get('calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('calendario-create', [CalendarioController::class, 'create'])->name('calendario.create');
    Route::get('calendario-edit/{id}', [CalendarioController::class, 'edit'])->name('calendario.edit');


    // Articulos
    Route::get('articulos', [ArticulosController::class, 'index'])->name('articulos.index');
    Route::get('articulo-create', [ArticulosController::class, 'create'])->name('articulo.create');
    Route::get('articulo-edit/{id}', [ArticulosController::class, 'edit'])->name('articulo.edit');

    // Empresas
    Route::get('empresas', [EmpresaController::class, 'index'])->name('empresas.index');
    Route::get('empresas-create', [EmpresaController::class, 'create'])->name('empresas.create');
    Route::get('empresas-edit/{id}', [EmpresaController::class, 'edit'])->name('empresas.edit');

    // Registrar usuarios
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios-create', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::get('usuarios-edit/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');

    // Registrar usuarios
    Route::get('departamentos', [DepartamentosUserController::class, 'index'])->name('departamentos.index');
    Route::get('departamento-create', [DepartamentosUserController::class, 'create'])->name('departamento.create');
    Route::get('departamento-edit/{id}', [DepartamentosUserController::class, 'edit'])->name('departamento.edit');

    // Cursos
    Route::get('cursos', [CursoController::class, 'index'])->name('cursos.index');
    Route::get('cursos-create', [CursoController::class, 'create'])->name('cursos.create');
    Route::get('cursos-edit/{id}', [CursoController::class, 'edit'])->name('cursos.edit');

    // Presupuestos
    Route::get('presupuestos', [PresupuestoController::class, 'index'])->name('presupuestos.index');
    Route::get('presupuestos-flujo', [PresupuestoController::class, 'trello'])->name('presupuestos.trello');
    Route::get('presupuestos-create', [PresupuestoController::class, 'create'])->name('presupuestos.create');
    Route::get('presupuestos-edit/{id}', [PresupuestoController::class, 'edit'])->name('presupuestos.edit');

    // Facturas
    Route::get('facturas', [FacturaController::class, 'index'])->name('facturas.index');
    Route::get('facturas-create', [FacturaController::class, 'create'])->name('facturas.create');
    Route::get('facturas-edit/{id}', [FacturaController::class, 'edit'])->name('facturas.edit');
    Route::get('factura/pdf/{id}', [FacturaController::class, 'pdf'])->name('facturas.pdf');
    Route::get('certificado/{id}', [FacturaController::class, 'certificado'])->name('certificado.pdf');

    // Productos
    Route::get('productos', [ProductosController::class, 'index'])->name('productos.index');
    Route::get('productos-create', [ProductosController::class, 'create'])->name('productos.create');
    Route::get('productos-edit/{id}', [ProductosController::class, 'edit'])->name('productos.edit');
    Route::get('productos/pdf', [IndexComponent::class, 'pdf'])->name('productos.pdf');

    // Productos Categories
    Route::get('productos-categories', [ProductosCategoriesController::class, 'index'])->name('productos-categories.index');
    Route::get('productos-categories-create', [ProductosCategoriesController::class, 'create'])->name('productos-categories.create');
    Route::post('productos-categories-store', [ProductosCategoriesController::class, 'store'])->name('productos-categories.store');
    Route::get('productos-categories-edit/{id}', [ProductosCategoriesController::class, 'edit'])->name('productos-categories.edit');
    Route::post('productos-categories-updated', [ProductosCategoriesController::class, 'updated'])->name('productos-categories.update');
    Route::delete('productos-categories-delete', [ProductosCategoriesController::class, 'delete'])->name('productos-categories.delete');

    // Iva de Productos Categories
    Route::get('iva', [IvaController::class, 'index'])->name('iva.index');
    Route::get('iva/create', [IvaController::class, 'create'])->name('iva.create');
    Route::get('iva/edit/{id}', [IvaController::class, 'edit'])->name('iva.edit');


    // Clients
    Route::get('clients-emails', [ClientsEmailController::class, 'index'])->name('clientEmail.index');
    Route::get('client-email-create', [ClientsEmailController::class, 'create'])->name('clientEmail.create');
    Route::post('client-email-store', [ClientsEmailController::class, 'store'])->name('clientEmail.store');
    Route::get('client-email-edit', [ClientsEmailController::class, 'edit'])->name('clientEmail.edit');
    Route::post('client-email-updated', [ClientsEmailController::class, 'updated'])->name('clientEmail.updated');
    Route::delete('client-email-delete', [ClientsEmailController::class, 'delete'])->name('clientEmail.delete');

    /* --------------------------------------- */
    // Payment_method
    Route::get('payments-method', [PaymentMethodController::class, 'index'])->name('paymentsMethod.index');
    Route::get('payment-method-create', [PaymentMethodController::class, 'create'])->name('paymentMethod.create');
    Route::post('payment-method-store', [PaymentMethodController::class, 'store'])->name('paymentMethod.store');
    Route::get('payment-method-edit', [PaymentMethodController::class, 'edit'])->name('paymentMethod.edit');
    Route::post('payment-method-updated', [PaymentMethodController::class, 'updated'])->name('paymentMethod.updated');
    Route::delete('payment-method-delete', [PaymentMethodController::class, 'delete'])->name('paymentMethod.delete');

    /* --------------------------------------- */
    // Projects
    Route::get('projects', [ProjectsController::class, 'index'])->name('projects.index');
    Route::get('project-create', [ProjectsController::class, 'create'])->name('project.create');
    Route::post('project-store', [ProjectsController::class, 'store'])->name('project.store');
    Route::get('project-edit', [ProjectsController::class, 'edit'])->name('project.edit');
    Route::post('project-updated', [ProjectsController::class, 'updated'])->name('project.updated');
    Route::delete('project-delete', [ProjectsController::class, 'delete'])->name('project.delete');

    // Projects Priority
    Route::get('projects-priority', [ProjectPriorityController::class, 'index'])->name('projectsPriority.index');
    Route::get('project-priority-create', [ProjectPriorityController::class, 'create'])->name('projectPriority.create');
    Route::post('project-priority-store', [ProjectPriorityController::class, 'store'])->name('projectPriority.store');
    Route::get('project-priority-edit', [ProjectPriorityController::class, 'edit'])->name('projectPriority.edit');
    Route::post('project-priority-updated', [ProjectPriorityController::class, 'updated'])->name('projectPriority.updated');
    Route::delete('project-priority-delete', [ProjectPriorityController::class, 'delete'])->name('projectPriority.delete');


    //Marketing
    Route::get('/newsletters', [NewslettersController::class, 'index'])->name('marketing.newsletters.index');
    Route::get('/newsletters-create', [NewslettersController::class,'create'])->name('marketing.newsletters.create');
    Route::post('/newsletters-store', [NewslettersController::class,'store'])->name('marketing.newsletters.store');
    Route::get('/newsletters/{newsletter}/edit', [NewslettersController::class,'edit'])->name('marketing.newsletters.edit');
    Route::post('/newsletters/{newsletter}', [NewslettersController::class,'update'])->name('marketing.newsletters.update');
    Route::get('/newsletters-statistics', [NewslettersController::class,'statistics'])->name('marketing.statistics');
    Route::post('/newsletters-statistics/get-info', [NewslettersController::class,'getInfoNewsletter'])->name('marketing.getInfo');
    Route::get('/smartnewsletter', [NewslettersController::class,'smartNewsletters'])->name('marketing.smartnewsletter');
    Route::post('/runsmartnewsletter', [NewslettersController::class,'runSmartNewsletters'])->name('marketing.runsmartnewsletter');
    Route::get('/newsletters-favourites', [NewslettersController::class,'favourites'])->name('marketing.newsletters.favourites');
    Route::post('/newsletters-add/{newsletter}', [NewslettersController::class,'addFavourites'])->name('marketing.newsletters.favourites.add');
    Route::post('/newsletters-send/{newsletter}', [NewslettersController::class,'send'])->name('marketing.newsletters.send');
    Route::delete('/newsletters-delete/{newsletter}', [NewslettersController::class,'destroy'])->name('marketing.newsletters.destroy');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('agenda', [AgendaController::class, 'index'])->name('agenda.index');

    // estadisticas
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    // Settings
    Route::get('clients', [ClientsController::class, 'index'])->name('clients.index');
    Route::get('clients/create', [ClientsController::class, 'create'])->name('clients.create');
    Route::get('clients/edit/{id}', [ClientsController::class, 'edit'])->name('clients.edit');

    // Eventos
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
    Route::get('/eventos-create', [EventoController::class, 'create'])->name('eventos.create');
    Route::get('/eventos-edit/{id}', [EventoController::class, 'edit'])->name('eventos.edit');

    // Servicios
    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
    Route::get('/servicios-create', [ServicioController::class, 'create'])->name('servicios.create');
    Route::get('/servicios-edit/{id}', [ServicioController::class, 'edit'])->name('servicios.edit');

    //Servicios disponibles
    Route::get('/servicios-disponibles', [DisponiblesController::class, 'index'])->name('disponible.index');

    // Servicios Categorias
    Route::get('/servicios-categorias', [ServicioCategoriaController::class, 'index'])->name('servicios-categorias.index');
    Route::get('/servicios-categorias-create', [ServicioCategoriaController::class, 'create'])->name('servicios-categorias.create');
    Route::get('/servicios-categorias-edit/{id}', [ServicioCategoriaController::class, 'edit'])->name('servicios-categorias.edit');

     // Servicios pack
     Route::get('/servicios-packs', [ServicioPackController::class, 'index'])->name('servicios-packs.index');
     Route::get('/servicios-packs-create', [ServicioPackController::class, 'create'])->name('servicios-packs.create');
     Route::get('/servicios-packs-edit/{id}', [ServicioPackController::class, 'edit'])->name('servicios-packs.edit');

     // Monitores
     Route::get('/monitores', [MonitorController::class, 'index'])->name('monitor.index');
     Route::get('/monitores-create', [MonitorController::class, 'create'])->name('monitor.create');
     Route::get('/monitores-edit/{id}', [MonitorController::class, 'edit'])->name('monitor.edit');

     // Programas
     Route::get('/programas', [ProgramaController::class, 'index'])->name('programas.index');
     Route::get('/programas-create', [ProgramaController::class, 'create'])->name('programas.create');
     Route::get('/programas-edit/{id}', [ProgramaController::class, 'edit'])->name('programas.edit');

     //Logs
     Route::get('/logs', [LogsController::class, 'index'])->name('logs.index');
     // Clientes
     Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
     Route::get('/pacientes-create', [PacienteController::class, 'create'])->name('pacientes.create');
     Route::get('/pacientes-edit/{id}', [PacienteController::class, 'edit'])->name('pacientes.edit');
    // Leads
     Route::get('/leads', [LeadsController::class, 'index'])->name('leads.index');
     Route::get('/leads-create', [LeadsController::class, 'create'])->name('leads.create');
     Route::get('/leads-edit/{id}', [LeadsController::class, 'edit'])->name('leads.edit');
    // Citas
     Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
     Route::get('/citas-create', [CitaController::class, 'create'])->name('citas.create');
     Route::get('/citas-create/{id}', [CitaController::class, 'createFrom'])->name('citas.create');
     Route::get('/citas-edit/{id}', [CitaController::class, 'edit'])->name('citas.edit');
     // Empresas
     Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');
     Route::get('/empresas-create', [EmpresaController::class, 'create'])->name('empresas.create');
     Route::get('/empresas-edit/{id}', [EmpresaController::class, 'edit'])->name('empresas.edit');
     // Aseguradoras
     Route::get('/aseguradoras', [AseguradoraController::class, 'index'])->name('aseguradoras.index');
     Route::get('/aseguradoras-create', [AseguradoraController::class, 'create'])->name('aseguradoras.create');
     Route::get('/aseguradoras-edit/{id}', [AseguradoraController::class, 'edit'])->name('aseguradoras.edit');
     // Plataformas
     Route::get('/plataformas', [PlataformaController::class, 'index'])->name('plataformas.index');
     Route::get('/plataformas-create', [PlataformaController::class, 'create'])->name('plataformas.create');
     Route::get('/plataformas-edit/{id}', [PlataformaController::class, 'edit'])->name('plataformas.edit');

     //Gastos
     Route::get('gastos', [GastoController::class, 'index'])->name('gastos.index');
     Route::get('gastos-create', [GastoController::class, 'create'])->name('gastos.create');
     Route::get('gastos-edit/{id}', [GastoController::class, 'edit'])->name('gastos.edit');

     Route::get('tipo-gasto', [TipoGastoController::class, 'index'])->name('tipo-gasto.index');
     Route::get('tipo-gasto-create', [TipoGastoController::class, 'create'])->name('tipo-gasto.create');
     Route::get('tipo-gasto-edit/{id}', [TipoGastoController::class, 'edit'])->name('tipo-gasto.edit');

	 Route::get('tipo-evento', [TipoEventoController::class, 'index'])->name('tipo-evento.index');
     Route::get('tipo-evento-create', [TipoEventoController::class, 'create'])->name('tipo-evento.create');
     Route::get('/tipo-evento-create-from-budget', [TipoEventoController::class, 'createFromBudget'])->name('tipo-evento.create-from-budget');
     Route::get('tipo-evento-edit/{id}', [TipoEventoController::class, 'edit'])->name('tipo-evento.edit');


     Route::get('categoria-contrato', [CategoriaEventoController::class, 'index'])->name('categoria-evento.index');
     Route::get('categoria-contrato-create', [CategoriaEventoController::class, 'create'])->name('categoria-evento.create');
     Route::get('categoria-contrato-edit/{id}', [CategoriaEventoController::class, 'edit'])->name('categoria-evento.edit');

     Route::get('caja', [CajaController::class, 'index'])->name('caja.index');
     Route::get('caja-create-ingreso', [CajaController::class, 'createIngreso'])->name('caja.create-ingreso');
     Route::get('caja-create-gasto', [CajaController::class, 'createGasto'])->name('caja.create-gasto');
     Route::get('caja-edit/{id}', [CajaController::class, 'edit'])->name('caja.edit');

     Route::get('/service/jwt', [MapKitController::class, 'getJwt']);

});
