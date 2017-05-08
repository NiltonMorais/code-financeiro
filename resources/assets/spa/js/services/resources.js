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
let BillPay = Vue.resource('bill_pays{/id}',{},{
    totalToday: {method: 'GET',url: 'bill_pays/total_today'},
    totalRestOfMonth: {method: 'GET', url: 'bill_pays/total_rest_of_month'}
});
let BillReceive = Vue.resource('bill_receives{/id}',{},{
    totalToday: {method: 'GET',url: 'bill_receives/total_today'},
    totalRestOfMonth: {method: 'GET', url: 'bill_receives/total_rest_of_month'}
});
let CashFlow = Vue.resource('cash_flows',{},{
    monthly: {method: 'GET',url: 'cash_flows/monthly'}
});
let Statement = Vue.resource('statements');

export {User, BankAccount, Bank, CategoryRevenue, CategoryExpense, BillPay, BillReceive, CashFlow, Statement};