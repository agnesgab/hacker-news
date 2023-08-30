<template>
       <div>
           <DataTable :data="data" :columns="columns" :options="options" class="table table-bordered" width="100%">
           </DataTable>
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
        };
    },
    setup() {
        const columns = [
            { title: "Title", width: "50%"},
            { title: "Points", width: "10%"},
            { title: "Posted at", width: ""},
            { title: "Link", width: ""},
            { title: null},
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
                    this.data = this.data.map(item => [
                        item.title,
                        item.points,
                        item.date_created,
                        this.generateLinkTag(item.link),
                        this.generateDeleteButton(item.id)
                    ]);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        generateLinkTag(itemLink) {
            return `<a href="${itemLink}" title="${itemLink}">Open</a>`;
        },
        generateDeleteButton(itemId)
        {
            return `<a href="/news/delete/${itemId}" onclick="if (!confirm('Are you sure?')) {event.stopPropagation(); event.preventDefault();}">Delete</a>`;
        }
    },
};
</script>
