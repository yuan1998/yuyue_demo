<template>
    <div id="app-scheduling">
        <div class="table-responsive" v-if="doctors.length">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="min-width: 120px;">医生</th>
                    <th scope="col" style="min-width: 100px;text-align: center;" v-for="index in monthDays"
                        :key="index">{{index}}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in doctors" :key="item.id">
                    <th scope="row">{{item.name}}</th>
                    <td v-for="index in monthDays"
                        :key="index"
                        :class=" !!doctorRest[item.id + '_' + index] && 'warning'  ">
                        <select @change="handleChange(item.id , index,$event)"
                                class="form-control" :value=" doctorRest[item.id + '_' + index] || 0 ">
                            <option v-for="(value ,key ) in status" :value="key">{{value}}</option>
                        </select>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props   : {
            doctors   : Array,
            statusList: Array,
        },
        data() {
            return {
                doctorRest: {},
                days      : 30,
                datePrefix: '',
                postList: {},
            }
        },
        mounted() {
            let m           = moment();
            this.days       = m.daysInMonth();
            this.datePrefix = m.format('YYYY-MM-');

            this.initRest();
        },
        methods : {
            initRest() {
                console.log("this.doctors :", this.doctors);

                this.doctors.forEach((item) => {
                    item.scheduling.forEach((scheduling) => {
                        let day = moment(scheduling.date).format('D');
                        this.$set(this.doctorRest, item.id + '_' + day, scheduling.scheduling_status_id);
                        console.log("this.doctorRest :", this.doctorRest);
                    });
                })
            },
            handleChange(id, day, evt) {
                let name =  id + '_' + day;
                if (this.postList[name]) {
                    alert('loading....');
                    return;
                }

                let data = {
                    doctor_id           : id,
                    date                : this.generateDate(day),
                    scheduling_status_id: parseInt(evt.target.value),
                };

                this.$set(this.postList , name , 1);
                this.handlePost(data ,  name );


            },
            async handlePost(data , name) {
                let res = await $.post('/api/scheduling',data);
                console.log("res :",res);
                this.$set(this.postList , name , 0);
                this.$set(this.doctorRest, name, data['scheduling_status_id']);
            },
            generateDate(day) {
                return this.datePrefix + (day >= 10 ? day : '0' + day);
            }
        },
        computed: {
            monthDays() {
                let arr = [];

                for (let i = 1 ; i <= this.days ; i++) {
                    arr.push(i);
                }
                console.log("arr :", arr);
                return arr;
            },
            status() {
                console.log("this.statusList :", this.statusList);
                let arr = {
                    0: '上班',
                };
                this.statusList.forEach((item) => {
                    arr[ item.id ] = item.name;
                });
                return arr;
            }
        }
    }
</script>

<style scoped>
    #app-scheduling select.form-control {
        border: none;
        background-color: transparent;
        color: inherit;
    }
</style>
