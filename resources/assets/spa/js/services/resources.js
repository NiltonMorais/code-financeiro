export class Jwt {
    static accessToken(email, password) {
        return Vue.http.post('access_token', {
            'email': email,
            'password': password
        });
    }

    static logout() {
        return Vue.http.post('logout');
    }

    static refreshToken() {
        return Vue.http.post('refresh_token');
    }
}

let User = Vue.resource('user');
let Bank = Vue.resource('banks');
let BankAccount = Vue.resource('bank_accounts{/id}', {}, {
    lists: {method: 'GET', url: 'bank_accounts/lists'}
});
let CategoryRevenue = Vue.resource('category_revenues{/id}');
let CategoryExpense = Vue.resource('category_expenses{/id}');
let BillPay = Vue.resource('bill_pays{/id}');
let BillReceive = Vue.resource('bill_receives{/id}');
let CashFlow = Vue.resource('cash_flows');

export {User, BankAccount, Bank, CategoryRevenue, CategoryExpense, BillPay, BillReceive, CashFlow};