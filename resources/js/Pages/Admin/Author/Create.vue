<template>

    <head>
        <title>Админ панель | Автор қосу</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Автор қосу</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.authors.index')">
                                <i class="fas fa-dashboard"></i>
                                Авторлар тізімі
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Автор қосу
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">Аты</label>
                            <input type="text" class="form-control" v-model="author.full_name" name="full_name" />
                        </div>
                        <div class="form-group">
                            <label for="">Лауазымы</label>
                            <input type="text" class="form-control" v-model="author.position" name="position" />
                        </div>
                        <div class="form-group">
                            <label for="">Дәрежесі</label>
                            <input type="text" class="form-control" v-model="author.degree" name="degree" />
                        </div>
                        <div class="form-group">
                            <label for="">Orcid</label>
                            <input type="text" class="form-control" v-model="author.orcid" name="orcid" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            Сақтау
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            Артқа
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
import ValidationError from "../../../Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    data() {
        return {
            author: {
                
            }
        }
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
        submit() {
            this.$inertia.post(
                route("admin.authors.store"),
                this.author,
                {
                    onError: () => console.log("An error has occurred"),
                    onSuccess: () =>
                        console.log("The new contact has been saved"),
                }
            );
        },
    },
};
</script>
