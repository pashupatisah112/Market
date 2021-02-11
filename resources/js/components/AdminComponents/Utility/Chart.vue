<script>
// CommitChart.js
import {
    Line
} from 'vue-chartjs'

export default {
    extends: Line,
    data() {
        return {
            //numDays: 0,
            userData: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            orderData: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
            dataLabels: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32]
        }
    },
    mounted() {
        this.getData()
        // Overwriting base render method with actual data.

    },
    methods: {
        // daysInThisMonth() {
        //     let now = new Date();
        //     this.numDays = new Date(now.getFullYear(), now.getMonth() + 1, 0).getDate();
        //         for(var i=0;i<=this.numDays;i++){
        //           this.dataLabels.push(i)
        //           //this.userData.push(0)
        //           //this.orderData.push(0)
        //       }
        // },
        getData() {
            axios.get('api/getDailyData')
                .then(res => {
                    for (var i = 0; i < res.data.user_data.length; i++) {
                        //this.userData.push(res.data[i].count)
                        this.userData[res.data.user_data[i].date] = res.data.user_data[i].count
                    }
                    for (var i = 0; i < res.data.order_data.length; i++) {
                        this.orderData[res.data.order_data[i].date] = res.data.order_data[i].count
                    }
                    this.renderChart({
                        labels: this.dataLabels,
                        datasets: [{
                            label: 'Users',
                            backgroundColor: '#f87979',
                            data: this.userData
                        },{
                            label: 'Orders',
                            backgroundColor: '#777777',
                            data: this.orderData
                        } ]
                    })
                })
                .catch(err => console.log(err.response))
        },
    }
}
</script>
