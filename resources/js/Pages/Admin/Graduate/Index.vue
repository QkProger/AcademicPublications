<template>

    <head>
        <title>{{ userData.lang_code == 'kz' ? 'Админ панель | Түлектер' : 'Yönetici paneli | Graduates' }}</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ userData.lang_code == 'kz' ? 'Түлектер' : 'Graduates' }}</h1>
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
                            {{ userData.lang_code == 'kz' ? 'Түлектер' : 'Personel' }}
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-danger mr-2" :href="route('admin.graduates.index')">
                <i class="fa fa-trash"></i> {{ userData.lang_code == 'kz' ? 'Фильтрді тазалау' : 'Filtrenin temizlenmesi' }}
                </Link>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-hover table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr user="row">
                                        <th>ID Контингента</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'ИИН' : 'IIN' }}</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'Фамилия' : 'Soyadı' }}</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'Аты' : 'Adı' }}</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'Әкесінің аты' : 'Baba Adı' }}</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'Бітірген жылы' : 'Finished Year' }}</th>
                                        <th>{{ userData.lang_code == 'kz' ? 'Өңдеу' : 'Düzenle' }}</th>
                                    </tr>
                                    <tr class="filters">
                                        <td>
                                            <input v-model="filter.id" class="form-control" placeholder='ID'
                                                @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.iin" class="form-control" placeholder='ИИН'
                                                @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.surname" class="form-control" placeholder='Фамилия'
                                                @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.name" class="form-control" placeholder='Аты'
                                                @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <input v-model="filter.second_name" class="form-control"
                                                placeholder='Әкесінің аты' @keyup.enter="search" />
                                        </td>
                                        <td>
                                            <select class="form-control" @change.prevent="search"
                                                v-model="filter.finishYear">
                                                <option :value="null">
                                                    {{ userData.lang_code == 'kz' ? 'Барлығы' : 'Her şey' }}
                                                </option>
                                                <option v-for="year in years"
                                                    :value="year">
                                                    {{ year }}
                                                </option>
                                            </select>
                                        </td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="graduate in graduates.data" :key="'graduate' + graduate.id">
                                        <td>{{ graduate }}</td>
                                        <td>{{ graduate.iinPlt }}</td>
                                        <td>{{ graduate.lastName }}</td>
                                        <td>{{ graduate.firstName }}</td>
                                        <td>{{ graduate.patronymic }}</td>
                                        <td>{{ graduate.finishOrderDate.substring(0, 4) }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="route('admin.graduates.edit', graduate)
                                                    " class="btn btn-primary" title="Изменить">
                                                <i class="fas fa-edit"></i>
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="graduates.links" />
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
    props: ["graduates"],
    data() {
        return {
            filter: {
                id: route().params.id ? route().params.id : null,
                name: route().params.name ? route().params.name : null,
                second_name: route().params.second_name ? route().params.second_name : null,
                surname: route().params.surname ? route().params.surname : null,
                iin: route().params.iin ? route().params.iin : null,
                finishYear: route().params.finishYear ? route().params.finishYear : null,
            },
            years: Array.from({ length: 2024 - 1986 + 1 }, (_, i) => 1986 + i),
            loading: 0,
        };
    },
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        userData() {
            return this.$store.getters.getUserData.user;
        }
    },
    methods: {
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route('admin.graduates.index'), params)
        },
    }
};
</script>
