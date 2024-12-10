<template>
    <head>
        <title>Админ панель | Автор</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Авторлар тізімі</h1>
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
                            Авторлар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.authors.create')">
                <i class="fa fa-plus"></i> Қосу
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
                                    <tr author="row">
                                        <th>ID</th>
                                        <th>Аты-жөні</th>
                                        <th>Лауазымы</th>
                                        <th>Дәрежесі</th>
                                        <th>Orcid</th>
                                        <th>Өңдеу/Жою</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd" v-for="(author, index) in authors.data" :key="'author' + author.id">
                                        <td>
                                            {{
                                                    author.id
                                                }}
                                        </td>
                                        <td>{{ author.full_name }}</td>
                                        <td>{{ author.position }}</td>
                                        <td>{{ author.degree }}</td>
                                        <td>{{ author.orcid }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="route('admin.authors.edit', author)" class="btn btn-primary" title="Изменить">
                                                <i class="fas fa-edit"></i>
                                                </Link>
    
                                                <button @click.prevent="deleteData(author.id)" class="btn btn-danger" title="Удалить">
                                                    <i class="fas fa-times"></i>
                                                </button>
    
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="authors.links" />
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
        props: ["authors"],
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
                        this.$inertia.delete(route('admin.authors.destroy', id))
                    }
                });
            },
            search() {
                this.loading = 1
                const params = this.clearParams(this.filter);
                this.$inertia.get(route('admin.authors.index'), params)
            },
        }
    };
    </script>