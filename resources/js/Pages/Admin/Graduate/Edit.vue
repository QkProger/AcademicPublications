<template>

    <head>
        <title v-if="userData.lang_code == 'kz'">Админ панель | Рөлді өзгерту</title>
        <title v-else>Yönetici paneli | Rol adını değiştir</title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0" v-if="userData.lang_code == 'kz'">Рөл атын өзгерту</h1>
                    <h1 class="m-0" v-else>Rol adını değiştir</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                {{ userData.lang_code == 'kz' ? 'Басты бет' : 'Ana sayfa' }}
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
                            Рөл атын өзгерту
                        </li>
                        <li class="breadcrumb-item active" v-else>
                            Rol adını değiştir
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
                            <label for="" >Аты</label>
                            <input type="text" class="form-control" v-model="graduate.firstName" name="firstName" />
                            <validation-error :field="'firstName'" />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            {{ userData.lang_code == 'kz' ? 'Сақтау' : 'Kaydet' }}
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            {{ userData.lang_code == 'kz' ? 'Артқа' : 'Dönüş' }}
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
    props: ["graduate"],
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
            this.$inertia.put(
                route("admin.graduates.update", this.graduate.id),
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
