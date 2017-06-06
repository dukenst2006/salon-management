import Datepicker from 'vuejs-datepicker';
import axios from 'axios';
import Vue from 'vue';
import moment from 'moment-es6';
Vue.config.productionTip = false;
axios.defaults.headers.common ={
    'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    'X-Requested-With': 'XMLHttpRequest'

};


Vue.component('datepicker',Datepicker);
Vue.component('alert',{

    props:['alertMessage'],
    template:`<div class = "alert" role = "alert">{{ alertMessage }}</div>`

});
let app = new Vue({

    el: '#root',

    data:{

        //datepicker properties
        bootstrapStyling:true,
        date: new Date(),
        dateFormat: 'MM/dd/yyyy',

        //table properties
        zeroAmount:'$ ' + 0.00,
        sqGrossSales: this.zeroAmount,
        sqTipsOnCard:this.zeroAmount,
        grossSales:this.zeroAmount,
        tipsOnCard:this.zeroAmount,
        giftCardSolds:this.zeroAmount,
        sqConvenienceFees:this.zeroAmount,
        sqProcessingFees:this.zeroAmount,

        //alert properties
        alertMessage:'',
        showAlert:false,
        noSale:false,


    },

    mounted(){

      this.getSales();

    },

    computed:{
        grossSalesDelta(){

            return ('$ ' + (this.sqGrossSales - this.grossSales));

        },
        tipsOnCardDelta(){

            return ('$ ' + (this.sqTipsOnCard - this.tipsOnCard));

        },
        isDiscrepancy(){
            return ((this.sqGrossSales  !== this.grossSales) || (this.sqTipsOnCard !== this.tipsOnCard));
        }

    },
    methods:{
        getSquareSales(dateString){

            return axios.get('/api/salon/square-sale?date=' + dateString);

        },

        getTechSales(dateString){

            return axios.get('/api/salon/tech-sale?date=' + dateString);
        },

        getSales(){

            let dateString = moment(this.date).format('YYYY-MM-DD');

            axios.all([this.getSquareSales(dateString),this.getTechSales(dateString)])
                .then(axios.spread(this.displaySales));

        },

        displaySales(square,tech){

            let sqData = square.data;
            let techData = tech.data;

            if(sqData.success){

                this.sqGrossSales = sqData.metrics.gross_sales;
                this.sqTipsOnCard = sqData.metrics.tips;
                this.sqProcessingFees = sqData.metrics.fees;
                this.sqConvenienceFees = sqData.metrics.salon_sale_details[0].gross_sales;
                this.giftCardSolds = sqData.metrics.salon_sale_details[1].gross_sales;
                this.showAlert = false;

            }
            else{

                this.alertMessage = 'No sale';
                this.noSale = true;
                this.showAlert = true;

            }

            this.grossSales = techData.grossSales;
            this.tipsOnCard = techData.tipsOnCard;

        },

        handleError(error){
            console.log(error);
        }

    }
});