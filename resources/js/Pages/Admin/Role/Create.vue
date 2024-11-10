<template>

    <head>
        <title v-if="userData.lang_code == 'kz'">Админ панель | Рөл қосу</title>
        <title v-else>Yönetici paneli | Rol ekle</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" v-if="userData.lang_code == 'kz'">Рөл қосу</h1>
                    <h1 class="m-0" v-else>Rol ekle</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')" v-if="userData.lang_code == 'kz'">
                                <i class="fas fa-dashboard"></i>
                                Басты бет
                            </a>
                            <a :href="route('admin.index')" v-else>
                                <i class="fas fa-dashboard"></i>
                                Ana sayfa
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.roles.index')" v-if="userData.lang_code == 'kz'">
                                <i class="fas fa-dashboard"></i>
                                Рөлдер тізімі
                            </a>
                            <a :href="route('admin.roles.index')" v-else>
                                <i class="fas fa-dashboard"></i>
                                Rollerin listesi
                            </a>
                        </li>
                        <li class="breadcrumb-item active" v-if="userData.lang_code == 'kz'">
                            Рөл қосу
                        </li>
                        <li class="breadcrumb-item active" v-else>
                            Rol ekle
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
                            <label for="" v-if="userData.lang_code == 'kz'">Аты</label>
                            <label for="" v-else>Adı</label>
                            <input type="text" class="form-control" v-model="role.name" name="name" />
                            <validation-error :field="'name'" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1" v-if="userData.lang_code == 'kz'">
                            Сақтау
                        </button>
                        <button type="submit" class="btn btn-primary mr-1" v-else>
                            Kaydet
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()" v-if="userData.lang_code == 'kz'">
                            Артқа
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()" v-else>
                            Dönüş
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
            role: {
                
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
                route("admin.roles.store"),
                this.role,
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
