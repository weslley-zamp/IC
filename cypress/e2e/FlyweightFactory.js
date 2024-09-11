
class FlyweightFactory {
    constructor() {
        this.contas = {};
        this.users = {};
    }

    getConta(nome, valor, vencimento, situacao) {
        const key = `${nome}-${valor}-${vencimento}-${situacao}`;
        if (!this.contas[key]) {
            this.contas[key] = { nome, valor, vencimento, situacao };
        }
        return this.contas[key];
    }

    getUser(name, email, password, password_confirmation) {
        const key = `${email}-${password}`;
        if (!this.users[key]) {
            this.users[key] = { name, email, password, password_confirmation };
        }
        return this.users[key];
    }
}

const factory = new FlyweightFactory();
export default factory;
