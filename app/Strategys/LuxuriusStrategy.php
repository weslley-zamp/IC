<?php
namespace App\Strategies\Budget;

class LuxuriousStrategy implements BudgetStrategy {
    public function calculateBudget(float $totalIncome, float $totalExpenses): float {
        $essentialExpenses = $totalExpenses * 0.6;
        return $totalIncome - $essentialExpenses;
    }
}
?>
