<?php

namespace Tests\Feature;

use Tests\TestCase;

class BudgetTest extends TestCase
{
    /**
     * Teste para verificar o cálculo do orçamento com estratégia moderada.
     */
    public function testModerateStrategy()
    {
        $response = $this->get('/budget?income=5000&expenses=3000&strategy=moderate');
        $response->assertStatus(200);
        $response->assertJson([
            'remainingBudget' => 2400,
        ]);
    }

    /**
     * Teste para verificar o cálculo do orçamento com estratégia econômica.
     */
    public function testEconomicStrategy()
    {
        $response = $this->get('/budget?income=5000&expenses=3000&strategy=economic');
        $response->assertStatus(200);
        $response->assertJson([
            'remainingBudget' => 2300,
        ]);
    }

    /**
     * Teste para verificar o cálculo do orçamento com estratégia luxuosa.
     */
    public function testLuxuriousStrategy()
    {
        $response = $this->get('/budget?income=5000&expenses=3000&strategy=luxurious');
        $response->assertStatus(200);
        $response->assertJson([
            'remainingBudget' => 2600,
        ]);
    }
}
?>
