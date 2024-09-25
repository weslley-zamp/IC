<?php
namespace App\Services;

use App\Strategies\Budget\BudgetStrategy;

class BudgetContext {
    private $strategy;

    public function setStrategy(BudgetStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function calculate(float $totalIncome, float $totalExpenses): float {
        return $this->strategy->calculateBudget($totalIncome, $totalExpenses);
    }
}
?>
