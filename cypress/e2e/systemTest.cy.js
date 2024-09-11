// Importar a FlyweightFactory
import factory from './FlyweightFactory';

describe('Gerenciamento de Contas', () => {
    const conta = factory.getConta('Conta de Teste', '123.45', '2024-12-31', 'Pendente');
    const contaEditada = factory.getConta('Conta de Teste Editada', '543.21', '2024-11-30', 'Paga');

    const user = factory.getUser('Novo Usuário', 'no8o@usuario.com', 'password123', 'password123');

    const baseUrl = 'http://localhost:8000';

    it('Teste de Sistema', () => {
        cy.visit(baseUrl);

        cy.get('input[name="name"]').type(user.name);
        cy.get('input[name="email"]').type(user.email);
        cy.get('input[name="password"]').type(user.password);
        cy.get('input[name="password_confirmation"]').type(user.password_confirmation);
        cy.get('button[type="submit"]').click();

        cy.url().should('include', '/index-conta');
        cy.contains('Cadastrar').click();

        cy.get('input[name="nome"]').should('be.visible').type(conta.nome);
        cy.get('input[name="valor"]').type(conta.valor);
        cy.get('input[name="vencimento"]').type(conta.vencimento);
        cy.get('select[name="situacao_conta_id"]').select(conta.situacao);

        cy.get('button[type="submit"]').contains('Cadastrar').click();
        cy.contains('OK').click();
        cy.contains('Listar').click();
        cy.url().should('include', '/index-conta');

        cy.get('input[name="nome"]').type(conta.nome);
        cy.contains(conta.nome).should('exist');
        cy.contains(conta.nome).parent().contains('Visualizar').click();
        cy.contains('Editar').click();

        cy.get('input[name="nome"]').clear().type(contaEditada.nome);
        cy.get('input[name="valor"]').clear().type(contaEditada.valor);
        cy.get('input[name="vencimento"]').clear().type(contaEditada.vencimento);
        cy.get('select[name="situacao_conta_id"]').select(contaEditada.situacao);

        cy.contains('Salvar').click();
        cy.contains('OK').click();
        cy.contains('Listar').click();

        cy.url().should('include', '/index-conta');
        cy.get('input[name="nome"]').type(contaEditada.nome);
        cy.contains(contaEditada.nome).should('exist');
        cy.contains(contaEditada.nome).parent().contains('Apagar').click();
        cy.contains('OK').click();

        cy.url().should('include', '/index-conta');
        cy.contains(contaEditada.nome).should('not.exist');

        cy.contains('Logout').click();
        cy.contains('Já registrado?').click();

        cy.get('input[name="email"]').type(user.email);
        cy.get('input[name="password"]').type(user.password);
        cy.contains('Entrar').click();

        cy.url().should('include', '/index-conta');
    });

});
