<template>
<head>
    <title>{{ userData.lang_code == 'kz' ? 'Админ панель | Қызметкерлер' : 'Yönetici paneli | Personel' }}</title>
</head>
<AdminLayout>
    <template #breadcrumbs>
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ userData.lang_code == 'kz' ? 'Қызметкерлер қосу беті' : 'Personel ekleme bölümü ' }}</h1>
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
                        {{ userData.lang_code == 'kz' ? 'Қызметкерлер' : 'Personel' }}
                    </li>
                </ol>
            </div>
        </div>
    </template>
    <template #header>
        <div class="buttons d-flex align-items-center">
            <Link class="btn btn-primary mr-2" :href="route('admin.users.create')">
            <i class="fa fa-plus"></i> {{ userData.lang_code == 'kz' ? 'Қосу' : 'Ekle' }}
            </Link>
            <Link class="btn btn-danger mr-2" :href="route('admin.users.index')">
            <i class="fa fa-trash"></i> Фильтрді тазалау
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
                                    <th>ID</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Аты' : 'Adı' }}</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Әкесінің аты' : 'Baba Adı' }}</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Фамилия' : 'Soyadı' }}</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Телефон номері' : 'Telefon Numarası' }}
                                    </th>
                                    <th>{{ userData.lang_code == 'kz' ? 'ИИН' : 'IIN' }}</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Почта' : 'E-posta' }}</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Қызметі' : 'Görevi' }}</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Активті' : 'Aktif' }}</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Рөлдері' : 'Rolleri' }}</th>
                                    <th>{{ userData.lang_code == 'kz' ? 'Өңдеу/Жою' : 'Düzenle/Sil' }}</th>
                                </tr>
                                <tr class="filters">
                                    <td>
                                        <input v-model="filter.id" class="form-control" placeholder='ID' @keyup.enter="search" />
                                    </td>
                                    <td>
                                        <input v-model="filter.name" class="form-control" placeholder='Аты' @keyup.enter="search" />
                                    </td>
                                    <td>
                                        <input v-model="filter.second_name" class="form-control" placeholder='Әкесінің аты' @keyup.enter="search" />
                                    </td>
                                    <td>
                                        <input v-model="filter.surname" class="form-control" placeholder='Фамилия' @keyup.enter="search" />
                                    </td>
                                    <td></td>
                                    <td>
                                        <input v-model="filter.iin" class="form-control" placeholder='ИИН' @keyup.enter="search" />
                                    </td>
                                    <td></td>
                                    <!-- <td>
                                            <select class="form-control" @change.prevent="search"
                                                v-model="filter.year">
                                                <option :value="null">
                                                    {{ userData.lang_code == 'kz' ? 'Барлығы' : 'Her şey' }}
                                                </option>
                                                <option v-for="year in years"
                                                    :value="year">
                                                    {{ year }} курс
                                                </option>
                                            </select>
                                        </td> -->
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd" v-for="(user, index) in users.data" :key="'user' + user.id">
                                    <td>
                                        {{
                                                user.id
                                            }}
                                    </td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.second_name }}</td>
                                    <td>{{ user.surname }}</td>
                                    <td>{{ user.phone }}</td>
                                    <td>{{ user.iin }}</td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.job }}</td>
                                    <td v-if="user.is_active">{{ userData.lang_code == 'kz' ? 'Ия' : 'Evet' }}</td>
                                    <td v-else>{{ userData.lang_code == 'kz' ? 'Жоқ' : 'Hayır' }}</td>
                                    <td>
                                        <div>{{ user.roles.map(role => role.name).join(', ') }}</div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <Link :href="route('admin.users.edit', user)" class="btn btn-primary" title="Изменить">
                                            <i class="fas fa-edit"></i>
                                            </Link>
                                            <button @click.prevent="deleteData(user.id)" class="btn btn-danger" title="Удалить">
                                                <i class="fas fa-times"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <Pagination :links="users.links" />
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
    props: ["users"],
    data() {
        return {
            filter: {
                id: route().params.id ? route().params.id : null,
                name: route().params.name ? route().params.name : null,
                second_name: route().params.second_name ? route().params.second_name : null,
                surname: route().params.surname ? route().params.surname : null,
                iin: route().params.iin ? route().params.iin : null,
                year: route().params.year ? route().params.year : null,
            },
            years: [1, 2, 3, 4, 5],
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
        deleteData(id) {
            Swal.fire({
                title: this.userData.lang_code == 'kz' ? "Жоюға сенімдісіз бе?" : "Silmek istediğinize emin misiniz?",
                text: this.userData.lang_code == 'kz' ? "Қайтып қалпына келмеуі мүмкін!" : "İyileşemeyebilir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: this.userData.lang_code == 'kz' ? "Иә, жоямын!" : "Evet sileceğim!",
                cancelButtonText: this.userData.lang_code == 'kz' ? "Жоқ" : "Hayır",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.delete(route('admin.users.destroy', id))
                }
            });

        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route('admin.users.index'), params)
        },
    }
};
</script>
