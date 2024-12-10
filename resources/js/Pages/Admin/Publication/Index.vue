<template>
    <head>
        <title>Админ панель | Публикациялар</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Публикациялар тізімі</h1>
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
                            Публикациялар тізімі
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <template #header>
            <div class="buttons d-flex align-items-center">
                <Link class="btn btn-primary mr-2" :href="route('admin.publications.create')">
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
                                    <tr>
                                        <th>ID</th>
                                        <th>Атауы</th>
                                        <th>Журнал</th>
                                        <th>Типі</th>
                                        <th>Авторы</th>
                                        <th>Жарияланған жылы</th>
                                        <th>Өңдеу/Жою</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="publication in publications.data" :key="'publication' + publication.id">
                                        <td>{{ publication.id }}</td>
                                        <td>{{ publication.title }}</td>
                                        <td>{{ publication.journal.name }}</td>
                                        <td>{{ publication.publication_type }}</td>
                                        <td><div v-for="(author, index) in publication.authors" :key="index">{{ author.full_name }} - {{ author.pivot.role }}</div></td>
                                        <td>{{ publication.publication_year }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <Link :href="route('admin.publications.edit', publication)" class="btn btn-primary" title="Изменить">
                                                    <i class="fas fa-edit"></i>
                                                </Link>
                                                <button @click.prevent="deleteData(publication.id)" class="btn btn-danger" title="Удалить">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="publications.links" />
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
    props: ["publications"],
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
                    this.$inertia.delete(route('admin.publications.destroy', id));
                }
            });
        }
    }
};
</script>
