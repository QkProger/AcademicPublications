<template>

    <head>
        <title v-if="userData.lang_code == 'kz'">Админ панель | Рөл</title>
        <title v-else>Yönetici paneli | Rolü</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" v-if="userData.lang_code == 'kz'">Рөлдер тізімі</h1>
                    <h1 class="m-0" v-else>Rollerin listesi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                {{ userData.lang_code == 'kz' ? 'Басты бет' : 'Ana sayfa' }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" v-if="userData.lang_code == 'kz'">
                            Рөлдер тізімі
                        </li>
                        <li class="breadcrumb-item active" v-else>
                            Rollerin listesi
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.roles.create')"
                    v-if="userData.lang_code == 'kz'">
                <i class="fa fa-plus"></i> Қосу
                </Link>
                <Link class="btn btn-primary mr-2" :href="route('admin.roles.create')" v-else>
                <i class="fa fa-plus"></i> Ekle
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
                                    <tr role="row">
                                        <th>ID</th>
                                        <th v-if="userData.lang_code == 'kz'">Аты</th>
                                        <th v-else>Kullanıcı türü</th>
                                        <th v-if="userData.lang_code == 'kz'">Өңдеу/Жою</th>
                                        <th v-else>Düzenle/Sil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="(role, index) in roles.data" :key="'role' + role.id">
                                        <td>
                                            {{
                                                role.id
                                            }}
                                        </td>
                                        <td>{{ role.name }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="route('admin.roles.edit', role)" class="btn btn-primary"
                                                    title="Изменить">
                                                <i class="fas fa-edit"></i>
                                                </Link>

                                                <button @click.prevent="deleteData(role.id)" class="btn btn-danger"
                                                    title="Удалить">
                                                    <i class="fas fa-times"></i>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="roles.links" />
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
    props: ["roles"],
    data() {
        return {
            filter: {
                name: route().params.name ? route().params.name : null,
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
                    this.$inertia.delete(route('admin.roles.destroy', id))
                }
            });
        },
        search() {
            this.loading = 1
            const params = this.clearParams(this.filter);
            this.$inertia.get(route('admin.roles.index'), params)
        },
    }
};
</script>
