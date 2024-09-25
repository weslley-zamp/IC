<?php
namespace App\Strategies\Budget;

class ModerateStrategy implements BudgetStrategy {
    public function calculateBudget(float $totalIncome, float $totalExpenses): float {
        $essentialExpenses = $totalExpenses * 0.8;
        return $totalIncome - $essentialExpenses;
    }
}
?>
