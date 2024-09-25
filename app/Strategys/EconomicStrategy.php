<?php
namespace App\Strategies\Budget;

class EconomicStrategy implements BudgetStrategy {
    public function calculateBudget(float $totalIncome, float $totalExpenses): float {
        $essentialExpenses = $totalExpenses * 0.9;
        return $totalIncome - $essentialExpenses;
    }
}
?>
