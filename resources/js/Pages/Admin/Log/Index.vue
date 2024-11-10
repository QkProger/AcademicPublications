<template>

    <head>
        <title>{{ userData.lang_code == 'kz' ? 'Админ панель | Логтар' : 'Yönetici paneli | Loglar' }}</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ userData.lang_code == 'kz' ? 'Логтар' : 'Loglar' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                {{ userData.lang_code == 'kz' ? 'Басты бет' : 'Ana sayfa' }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ userData.lang_code == 'kz' ? 'Логтар' : 'Loglar' }}
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-danger mr-2" :href="route('admin.logs.index')">
                <i class="fa fa-trash"></i> {{ userData.lang_code == 'kz' ? 'Фильтрді тазалау' : 'Filtrenin temizlenmesi' }}
                </Link>
                <div class="btn btn-warning" @click.prevent="changeLogStatus()" v-if="log_status">
                    {{ userData.lang_code == 'kz' ? 'Логтауды өшіру' : 'Logları sil' }}
                </div>
                <div class="btn btn-success" @click.prevent="changeLogStatus()" v-else>
                    {{ userData.lang_code == 'kz' ? 'Логтауды қосу' : 'Logları ekle' }}
                </div>
                <div v-if="loading" class="spinner-border text-primary mx-3" log="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr log="row">
                                        <th>№</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'Қолданушының аты-жөні' : 'Kullanıcı adı' }}</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'Әрекет' : 'İşlem' }}</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'Дата' : 'Tarih' }}</th>
                                    </tr>
                                    <tr class="filters">
                                        <td></td>
                                        <td>
                                            <input v-model="filter.fio" class="form-control"
                                                :placeholder=fioPlaceHolder @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <select class="form-control" @change.prevent="search"
                                                v-model="filter.type_id">
                                                <option :value="null">
                                                    {{ userData.lang_code == 'kz' ? 'Барлығы' : 'Her şey' }}
                                                </option>
                                                <option v-for="typee in types" :key="'typee' + typee.id"
                                                    :value="typee.id">
                                                    {{ typee.name }}
                                                </option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="(log, index) in logs.data" :key="'log' + log.id">
                                        <td>
                                            {{
                                                log.from
                                                    ? log.from + index
                                                    : index + 1
                                            }}
                                        </td>
                                        <td>{{ log.user.fio }}</td>
                                        <td>{{ userData.lang_code == 'kz' ? log.name : log.tr_name }}</td>
                                        <td>{{ formatDateTime(log.created_at) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="logs.links" />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        Head
    },
    props: ["logs", "log_status", "types"],
    data() {
        return {
            filter: {
                fio: route().params.fio ? route().params.fio : null,
                type_id: route().params.type_id ? route().params.type_id : null,
            },
            loading: 0,
        };
    },
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        },
        fioPlaceHolder() {
            return this.$store.getters.getUserData.user.lang_code === 'kz' ? 'Қолданушының аты-жөні' : 'Kullanıcı fio'
        }
    },
    methods: {
        changeLogStatus() {
            this.$inertia.post(
                route("admin.log.changeLogStatus")
            );
        },
        formatDateTime(dateTime) {
            if (!dateTime) return '';
            const date = new Date(dateTime);
            const formattedDate = `${date.getFullYear()}-${(date.getMonth() + 1).toString().padStart(2, '0')}-${date.getDate().toString().padStart(2, '0')} `;
            const formattedTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}:${date.getSeconds().toString().padStart(2, '0')}`;

            return `${formattedDate}${formattedTime}`;
        },
        deleteData(id) {
            Swal.fire({
                title: "Жоюға сенімдісіз бе?",
                text: "Қайтып қалпына келмеуі мүмкін!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Иә, жоямын!",
                cancelButtonText: "Жоқ",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(route('admin.logs.destroy', id))
                }
            });


        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route('admin.logs.index'), params)
        },
    }
};
</script>
