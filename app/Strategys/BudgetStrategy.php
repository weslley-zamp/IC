<?php
namespace App\Strategies\Budget;

interface BudgetStrategy {
    public function calculateBudget(float $totalIncome, float $totalExpenses): float;
}
?>
