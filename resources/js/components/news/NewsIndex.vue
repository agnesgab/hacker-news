<template>
       <div>
           <DataTable :data="dataArray" :columns="columns" :options="options" class="table table-bordered" width="100%" />
       </div>
</template>
<script>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import Buttons from 'datatables.net-buttons-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-responsive-bs5';
import axios from "axios";

DataTable.use(DataTablesCore);
DataTable.use(Buttons);

export default {
    components: {
        DataTable,
    },
    data() {
        return {
            data: [],
            dataArray: [],
        };
    },
    setup() {
        const columns = [
            { title: "Title", width: "40%"},
            { title: "Points", width: ""},
            { title: "Posted at", width: ""},
            { title: "Link", width: ""},
            { title: ""},
        ];

        const options = {
            responsive: true,
            ordering: false,
            pageLength: 10,
            lengthChange: false,
            searching: false,
        }

        return {
            columns,
            options
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios.get('/api/')
                .then(response => {
                    this.data = response.data.data;
                    this.dataArray = this.data.map(item => [
                        item.title,
                        item.points,
                        item.date_created,
                        `<a href="${item.link}">Open</a>`,
                        `<button @click='deleteNewsItem(${item.id})'>Delete</button>`, // Checkbox
                    ]);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        deleteNewsItem(id) {
            alert(id);
        },
    },
};
</script>
