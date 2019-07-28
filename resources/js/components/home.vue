<template>
    <div id="app-home">
        <div v-if="doctors && doctors.length">
            <vue-cal :selected-date="today"
                     default-view="day"
                     hide-view-selector
                     hide-title-bar
                     :time-from="7 * 60"
                     :time-step="30"
                     :split-days="doctorData.split"
                     :events="doctorData.data"
                     :sticky-split-labels="stickySplitLabels"
                     :min-cell-width="minCellWidth">
            </vue-cal>
        </div>
    </div>

</template>

<script>
    import vuecal from 'vue-cal';

    export default {
        props     : {
            doctors: Array,
            today: String,
        },
        components: {
            'vue-cal': vuecal,
        },
        computed  : {
            doctorData() {
                let doctorSplit     = [];
                let reservationData = [];
                let now = moment();

                this.doctors.forEach((item, index) => {
                    let doctorStatus = '';


                    item.scheduling.forEach(($item) => {
                        let status = $item.scheduling_status;
                        let day    = now.format('YYYY-MM-DD');
                        let start  = status.all_day ? day + ' 00:00:00' : day + ' ' + status.begin_time;
                        let end    = status.all_day ? day + ' 23:00:00' : day + ' ' + status.end_time;

                        if (!doctorStatus && this.diffNow(start, end)) {
                            doctorStatus = '休息中';
                        }

                        reservationData.push({
                            start     : start,
                            end       : end,
                            title     : status.name,
                            split     : index + 1,
                            class     : 'lunch',
                            background: true
                        })
                    });

                    item.reservation.forEach((each) => {
                        let project = each.project;

                        if (!doctorStatus && this.diffNow(each.begin_time, each.end_time)) {
                            doctorStatus = '手术中';
                        }

                        reservationData.push({
                            start  : each.begin_time,
                            end    : each.end_time,
                            title  : each.name + ' 预约了 ' + project.name,
                            content: '',
                            split  : index + 1,
                            class  : 'sport'
                        })
                    });

                    doctorSplit.push(
                        {
                            class: (index % 2 === 0) ? 'odd' : 'even',
                            label: item.name + ' (' + (doctorStatus || '空闲中') + ')'
                        }
                    );
                });
                return {
                    split: doctorSplit,
                    data : reservationData,
                }
            }
        },
        data() {
            return {
                stickySplitLabels: false,
                minCellWidth     : 1400,
            }
        },
        mounted() {
            document.querySelector('.vuecal__flex.vuecal__cells.day-view .vuecal__flex').style.minWidth = (this.doctors.length * 250) + 'px';
        },
        methods   : {
            diffNow(begin, end) {
                return moment().isBetween(begin, end);
            }
        }

    }
</script>
