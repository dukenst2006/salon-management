<template>
	<v-card class = "elevation-1 white" v-if="totalSales.length > 0">
		<v-card-text>
			<v-data-table :headers="headers" :items="totalSales"
			              hide-actions v-if="screenWidth > 768">
				<template slot="headers" scope="props">
					<th v-for="header in props.headers" :key="header.text">
						<p class = "subheading text-lg-center">{{ header.text }}</p>
					</th>
				</template>
				<template slot="items" scope="props">
					<td class = "text-xs-right subheading">$ {{ props.item.subTotal }}</td>
					<td class = "text-xs-right subheading">$ {{ props.item.subTotalTip }}</td>
					<td class = "text-xs-right subheading">$ {{ props.item.earnedTotal }}</td>
					<td class = "text-xs-right subheading">$ {{ props.item.earnedTip }}</td>
					<td class = "text-lg-center red--text headline">$ {{ props.item.total }}</td>
				</template>
			</v-data-table>
			<v-data-table :headers="headers" :items="totalSales"
			              hide-actions v-else>
				<template slot="headers" scope="props">
					<tr id = "small-screen-size-table-header"></tr>
				</template>
				<template slot="items" scope="props">
					<tr>
						<th>Sub Total</th>
						<td class = "text-xs-right subheading">$ {{ props.item.subTotal }}</td>
					</tr>
					<tr>
						<th>Sub Total Tip</th>
						<td class = "text-xs-right subheading">$ {{ props.item.subTotalTip }}</td>
					</tr>
					<tr>
						<th>Earned Total</th>
						<td class = "text-xs-right subheading">$ {{ props.item.earnedTotal }}</td>
					</tr>
					<tr>
						<th>Credit Card Tip</th>
						<td class = "text-xs-right subheading">$ {{ props.item.earnedTip }}</td>
					</tr>
					<tr>
						<th>Wage</th>
						<td class = "text-xs-right subheading">$ {{ props.item.total }}</td>
					</tr>
				</template>
			</v-data-table>

		</v-card-text>

	</v-card>
	<v-card v-else>
		<v-card-text>
			<p class = "title">No Wages Found</p>
		</v-card-text>

	</v-card>
</template>

<script>
    export default {
        props: ['totalSales'],

        data() {
            return {
                headers: [
                    {text: 'Sub Total', value: 'subTotal', sortable: false},
                    {text: 'Sub Total Tip', value: 'subTotalTip', sortable: false},
                    {text: 'Earned Total', value: 'earnedTotal', sortable: false},
                    {text: 'Tip Deduction', value: 'earnedTip', sortable: false},
                    {text: 'To Pay', value: 'total', sortable: false},

                ],
                screenWidth:window.innerWidth,
                screenHeight:window.innerHeight,
	            loadingSale:true,
            }


        },
        watch:{
            totalSales(){
                if((this.totalSales).length >= 0){
                    this.loadingSale = false;
                }
            }
        },
        methods: {}


    }
</script>

<style>
	#small-screen-size-table-header{
		height: 0 !important;
	}

</style>