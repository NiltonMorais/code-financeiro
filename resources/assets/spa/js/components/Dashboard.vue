<template>
        <div class="row">
            <div class="col s8">
                <div class="row">
                    <div class="col s6">
                        <div class="row card-panel">
                            <div class="center">
                                <div class="preloader-wrapper big active" v-show="loadingRevenue">
                                    <div class="spinner-layer spinner-green">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-show="!loadingRevenue">
                                <h5>A receber hoje</h5>
                                <h3 id="revenue-number" class="green-text center">{{totalTodayReceive | numberFormat true}}</h3>
                                <p class="left">Restante do mês</p>
                                <p class="right">{{totalRestOfMonthReceive | numberFormat true}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col s6">
                        <div class="row card-panel">
                            <div class="center">
                                <div class="preloader-wrapper big active" v-show="loadingExpense">
                                    <div class="spinner-layer spinner-red">
                                        <div class="circle-clipper left">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="gap-patch">
                                            <div class="circle"></div>
                                        </div>
                                        <div class="circle-clipper right">
                                            <div class="circle"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-show="!loadingExpense">
                                <h5>A pagar hoje</h5>
                                <h3 id="expense-number" class="red-text center">{{totalTodayPay | numberFormat true}}</h3>
                                <p class="left">Restante do mês</p>
                                <p class="right">{{totalRestOfMonthPay | numberFormat true}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row card-panel">
                    <div class="center" v-show="loadingChart">
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="hasCashFlowsMonthly">
                    <vue-chart :chart-type="chartOptions.chartType"
                               :columns="chartOptions.columns"
                               :rows="chartOptions.rows"
                               :options="chartOptions.options"
                               :chart-events="chartOptions.chartEvents"></vue-chart>
                    </div>
                </div>
            </div>
            <div class="col s4">
                <div class="row card-panel">
                    <div class="center" v-show="loadingBankAccountList">
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="collection" id="bank-account-list" v-show="!loadingBankAccountList">
                    <li class="collection-item avatar"  v-for="o in bankAccounts">
                        <img :src="o.bank.data.logo" class="circle">
                        <span class="title"><strong>{{o.name}}</strong></span>
                        <p>{{o.balance | numberFormat true}}</p>
                    </li>
                </ul>
                </div>
            </div>
        </div>
</template>
<script>
    import store from '../store/store';
    import VueCharts from 'vue-charts';
    import 'jquery.animate-number';
    import {User} from '../services/resources';

    Vue.use(VueCharts);
    export default{
        data(){
            return {
                loadingBankAccountList: true,
                loadingChart: true,
                loadingRevenue: true,
                loadingExpense: true,
            }
        },
        computed: {
            bankAccounts(){
                return store.state.bankAccount.bankAccounts;
            },
            cashFlowsMonthly(){
                return store.state.cashFlow.cashFlowsMonthly;
            },
            hasCashFlowsMonthly(){
                return store.getters['cashFlow/hasCashFlowsMonthly'];
            },
            totalTodayReceive(){
                return store.state.billReceive.total_today;
            },
            totalRestOfMonthReceive(){
                return store.state.billReceive.total_rest_of_month;
            },
            totalTodayPay(){
                return store.state.billPay.total_today;
            },
            totalRestOfMonthPay(){
                return store.state.billPay.total_rest_of_month;
            },
            chartOptions(){
                let self = this;
                let obj = {
                    chartType: 'ColumnChart',
                    chartEvents: {
                        ready(){
                            self.loadingChart = false;
                        }
                    },
                    columns: [
                        {'type': 'string', 'label': 'Dia'},
                        {'type': 'number', 'label': 'Receita'},
                        {'type': 'string', 'role': 'style'},
                        {'type': 'number', 'label': 'Despesa'},
                        {'type': 'string', 'role': 'style'},
                    ],
                    rows: [
                    ],
                    options: {
                        title: 'Fluxo de caixa mensal',
                        isStacked: true,
                        bar: {groupWidth: '40%'},
                        legend: {position: 'top'},
                        colors: ['green','red'],
                        animation: {
                            duration: 3000,
                            easing: 'out',
                            startup: true
                        }
                    }
                };
                for(let period of this.cashFlowsMonthly.period_list){
                    obj.rows.push([
                        this.$options.filters.dayMonth(period.period),
                        period.revenues.total == 0 ? null : period.revenues.total, 'green',
                        period.expenses.total == 0 ? null : -period.expenses.total, 'red',
                    ])
                }
                return obj;
            }
        },
        created(){
            this.store();
            this.echo();
        },
        methods: {
            store(){
                store.commit('bankAccount/setOrder','balance');
                store.commit('bankAccount/setSort','desc');
                store.commit('bankAccount/setLimit',5);
                store.dispatch('bankAccount/query').then(()=>{
                    this.loadingBankAccountList = false;
                    Materialize.showStaggeredList('#bank-account-list');
                });
                store.dispatch('cashFlow/monthly');

                let self = this;

                store.dispatch('billReceive/totalRestOfMonth');
                store.dispatch('billReceive/totalToday').then(()=>{
                    this.loadingRevenue = false;
                    $("#revenue-number").animateNumber({
                        number: self.totalTodayReceive,
                        numberStep(now,tween){
                            let number = self.$options.filters.numberFormat.read(now, true);
                            $(tween.elem).text(number);
                        }
                    })
                });

                store.dispatch('billPay/totalRestOfMonth');
                store.dispatch('billPay/totalToday').then(()=>{
                    this.loadingExpense = false;
                    $("#expense-number").animateNumber({
                        number: self.totalTodayPay,
                        numberStep(now,tween){
                            let number = self.$options.filters.numberFormat.read(now, true);
                            $(tween.elem).text(number);
                        }
                    })
                });
            },
            echo(){
                User.get().then((response) => {
                    Echo.private(`client.${response.data.clientId}`)
                        .listen('.CodeFin.Events.BankAccountBalanceUpdatedEvent', (event)=>{
                            this.updateBalance(event.bankAccount);
                        });
                })
            },
            findIndexBankAccount(id){
                let index = this.bankAccounts.findIndex(item => {
                    return item.id == id;
                });
                return index;
            },
            updateBalance(bankAccount){
                let index = this.findIndexBankAccount(bankAccount.id);
                if(bankAccount != -1){
                    store.commit('bankAccount/updateBalance',{
                        index,
                        balance: bankAccount.balance
                    });
                }
                let balance = this.$options.filters.numberFormat.read(bankAccount.balance, true);
                Materialize.toast(`Novo saldo para ${bankAccount.name} - ${balance}`,5000);
            }
        }
    }
</script>

<style type="text/css" scoped>
    .collection{
        border: none;
    }
    .collection-item{
        border-left: none;
        border-right: none;
        border-top: none;
    }
</style>