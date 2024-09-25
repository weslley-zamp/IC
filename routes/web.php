<?php

use App\Http\Controllers\ContaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
use App\Services\BudgetContext;
use App\Strategies\Budget\EconomicStrategy;
use App\Strategies\Budget\ModerateStrategy;
use App\Strategies\Budget\LuxuriousStrategy;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// CONTAS
Route::get('/', function () {
    return view('auth/register');
});

Route::middleware('conta')->group(function () {
    Route::get('/index-conta', [ContaController::class, 'index'])->name('conta.index');
    Route::get('/create-conta', [ContaController::class, 'create'])->name('conta.create');
    Route::post('/store-conta', [ContaController::class, 'store'])->name('conta.store');
    Route::get('/show-conta/{conta}', [ContaController::class, 'show'])->name('conta.show');
    Route::get('/edit-conta/{conta}', [ContaController::class, 'edit'])->name('conta.edit');
    Route::put('/update-conta/{conta}', [ContaController::class, 'update'])->name('conta.update');
    Route::delete('/destroy-conta/{conta}', [ContaController::class, 'destroy'])->name('conta.destroy');
    Route::post('/restore-conta', [ContaController::class, 'restore'])->name('conta.restore');
    Route::get('/change-situation-conta/{conta}', [ContaController::class, 'changeSituation'])->name('conta.change-situation');
    Route::get('/gerar-pdf-conta', [ContaController::class, 'gerarPdf'])->name('conta.gerar-pdf');
    Route::get('/gerar-csv-conta', [ContaController::class, 'gerarCsv'])->name('conta.gerar-csv');
    Route::get('/gerar-word-conta', [ContaController::class, 'gerarWord'])->name('conta.gerar-word');
});

// AUTH
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Nova rota para atualizar o perfil usando o builder
    Route::post('/profile/update', function(Request $request) {
        $controller = ProfileController::builder()
            ->fields(['name', 'email']) // Ajuste os campos conforme necessário
            ->redirect('dashboard')
            ->successMessage('perfil-atualizado');

        return $controller->updateProfile($request);
    })->name('profile.update');
});

// Rota para calcular o orçamento
Route::get('/budget', function () {
    $income = request('income', 5000);  // Obtém a renda da requisição
    $expenses = request('expenses', 3000);  // Obtém as despesas da requisição
    $strategyType = request('strategy', 'moderate');  // Define a estratégia padrão como moderada

    // Inicializa o contexto
    $context = new BudgetContext();

    // Escolhe a estratégia com base no parâmetro passado
    switch ($strategyType) {
        case 'economic':
            $context->setStrategy(new EconomicStrategy());
            break;
        case 'luxurious':
            $context->setStrategy(new LuxuriousStrategy());
            break;
        default:
            $context->setStrategy(new ModerateStrategy());
            break;
    }

    // Calcula o orçamento
    $remainingBudget = $context->calculate($income, $expenses);

    return response()->json([
        'remainingBudget' => $remainingBudget
    ]);
})->name('budget.calculate');

require __DIR__.'/auth.php';
